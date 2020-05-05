<?php

namespace Softspring\CustomerBundle\Platform\Adapter\Stripe;

use Softspring\CustomerBundle\Model\CustomerBillingAddressInterface;
use Softspring\CustomerBundle\Platform\Adapter\CustomerAdapterInterface;
use Softspring\CustomerBundle\Platform\Exception\PlatformException;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Platform\PlatformInterface;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\TaxId;

class CustomerAdapter extends AbstractStripeAdapter implements CustomerAdapterInterface
{
    protected static function prepareDataForPlatform(CustomerInterface $customer, string $action = ''): array
    {
        $data = [
            'customer' => [],
        ];

        if (method_exists($customer, 'getEmail')) {
            $data['customer']['email'] = $customer->getEmail();
        }

        if ($customer->getTaxIdCountry() && $customer->getTaxIdNumber()) {
            // @see https://stripe.com/docs/billing/taxes/tax-ids
            switch (strtolower($customer->getTaxIdCountry())) {
                case 'es':
                    $type = 'es_cif';
                    break;

                default:
                    $type = null;
                    break;
            }

            if ($type) {
                $data['tax_id'] = [
                    'type' => $type,
                    'value' => $customer->getTaxIdNumber(),
                ];
            }
        }

        if (method_exists($customer, 'getName')) {
            $data['customer']['name'] = $customer->getName();
        }

        if ($customer instanceof CustomerBillingAddressInterface && $customer->getBillingAddress()) {
            $data['customer']['description'] = $data['customer']['name'];

            $data['customer']['name'] = trim("{$customer->getBillingAddress()->getName()} {$customer->getBillingAddress()->getSurname()}");
            $data['customer']['address']['line1'] = $customer->getBillingAddress()->getStreetAddress();
            $data['customer']['address']['line2'] = $customer->getBillingAddress()->getExtendedAddress();
            $data['customer']['address']['city'] = $customer->getBillingAddress()->getLocality();
            $data['customer']['address']['postal_code'] = $customer->getBillingAddress()->getPostalCode();
            $data['customer']['address']['state'] = $customer->getBillingAddress()->getRegion();
            $data['customer']['address']['country'] = $customer->getBillingAddress()->getCountryCode();

            if ($customer->getBillingAddress()->getTel()) {
                $data['customer']['phone'] = $customer->getBillingAddress()->getTel();
            }
        }

        return $data;
    }

    public function syncCustomer(CustomerInterface $customer, Customer $customerStripe)
    {
        $customer->setPlatform(PlatformInterface::PLATFORM_STRIPE);
        $customer->setPlatformId($customerStripe->id);
        $customer->setTestMode(!$customerStripe->livemode);
        $customer->setPlatformLastSync(\DateTime::createFromFormat('U', $customerStripe->created)); // TODO update last sync date
        $customer->setPlatformConflict(false);
        $customer->setPlatformData($customerStripe->toArray());
    }

    /**
     * @inheritDoc
     */
    public function create(CustomerInterface $customer)
    {
        try {
            $this->initStripe();

            // prepare data for stripe
            $data = self::prepareDataForPlatform($customer, 'create');

            $customerStripe = $this->stripeClientCreate($data['customer']);

            $this->logger && $this->logger->info(sprintf('Stripe created customer %s', $customerStripe->id));

            $this->syncCustomer($customer, $customerStripe);
            $this->updateTaxId($customerStripe, $data);

            return $customerStripe;
        } catch (\Exception $e) {
            return $this->attachStripeExceptions($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function update(CustomerInterface $customer)
    {
        try {
            $this->initStripe();

            // prepare data for stripe
            $data = self::prepareDataForPlatform($customer, 'update');

            /** @var Customer $customerStripe */
            $customerStripe = $this->get($customer);
            $customerStripe->updateAttributes($data['customer']);
            $customerStripe->save();

            $this->logger && $this->logger->info(sprintf('Stripe updated customer %s', $customerStripe->id));

            $this->syncCustomer($customer, $customerStripe);
            $this->updateTaxId($customerStripe, $data);

            return $customerStripe;
        } catch (\Exception $e) {
            return $this->attachStripeExceptions($e);
        }
    }

    /**
     * @param Customer $customerStripe
     * @param array    $dataForPlatform
     */
    protected function updateTaxId(Customer $customerStripe, array $dataForPlatform)
    {
        if (empty($dataForPlatform['tax_id'])) {
            return;
        }

        $action = 'create';
        foreach ($customerStripe->tax_ids->getIterator() as $taxId) {
            if ($taxId->type == $dataForPlatform['tax_id']['type']) {
                if ($taxId->value == $dataForPlatform['tax_id']['value']) {
                    $action = 'none';
                } else {
                    $action = 'update';
                    $deleteTaxId = $taxId->id;
                }
            }
        }

        if ($action == 'create') {
            $this->stripeClientTaxIdCreate($customerStripe->id, $dataForPlatform['tax_id']);
        } elseif ($action == 'update') {
            $this->stripeClientTaxIdDelete($customerStripe->id, $deleteTaxId);
            $this->stripeClientTaxIdCreate($customerStripe->id, $dataForPlatform['tax_id']);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(CustomerInterface $customer)
    {
        try {
            $this->initStripe();

            /** @var Customer $customerStripe */
            $customerStripe = $this->get($customer);
            $customerStripe->delete();

            $this->logger && $this->logger->info(sprintf('Stripe deleted customer %s', $customerStripe->id));

            $customer->setPlatformId(null);

            return;
        } catch (\Exception $e) {
            return $this->attachStripeExceptions($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(CustomerInterface $customer)
    {
        try {
            $this->initStripe();

            $customerStripe = $this->stripeClientRetrieve([
                'id' => $customer->getPlatformId(),
            ]);

            $this->syncCustomer($customer, $customerStripe);

            return $customerStripe;
        } catch (\Exception $e) {
            return $this->attachStripeExceptions($e);
        }
    }

    /**
     * @param CustomerInterface $customer
     *
     * @return array
     * @throws PlatformException
     */
    public function invoices(CustomerInterface $customer): array
    {
        try {
            $this->initStripe();

            return Invoice::all([
                'customer' => $customer->getPlatformId(),
            ])->data;
        } catch (\Exception $e) {
            return $this->attachStripeExceptions($e);
        }
    }


    protected function stripeClientCreate($params = null, $options = null): Customer
    {
        return Customer::create($params, $options);
    }

    protected function stripeClientRetrieve($id, $opts = null): Customer
    {
        return Customer::retrieve($id, $opts);
    }

    protected function stripeClientTaxIdCreate($id, $params = null, $opts = null): TaxId
    {
        return Customer::createTaxId($id, $params, $opts);
    }

    protected function stripeClientTaxIdDelete($id, $taxIdId, $params = null, $opts = null): TaxId
    {
        return Customer::deleteTaxId($id, $taxIdId, $params, $opts);
    }
}