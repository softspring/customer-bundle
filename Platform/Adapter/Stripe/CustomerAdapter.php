<?php

namespace Softspring\CustomerBundle\Platform\Adapter\Stripe;

use Softspring\CustomerBundle\Platform\Adapter\CustomerAdapterInterface;
use Softspring\CustomerBundle\Platform\Exception\PlatformException;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Platform\PlatformInterface;
use Stripe\Customer;
use Stripe\Invoice;

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

        return $data;
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

            /** @var Customer $customerStripe */
            $customerStripe = Customer::create($data['customer']);

            $this->logger && $this->logger->info(sprintf('Stripe created customer %s', $customerStripe->id));

            // save platform data
            $customer->setPlatform(PlatformInterface::PLATFORM_STRIPE);
            $customer->setPlatformId($customerStripe->id);
            $customer->setTestMode(!$customerStripe->livemode);
            // $customer->setPlatformLastSync($customerStripe->created);
            $customer->setPlatformConflict(false);
            $customer->setPlatformData($customerStripe->toArray());

            if (isset($data['tax_id'])) {
                Customer::createTaxId($customerStripe->id, $data['tax_id']);
            }

            return $customerStripe;
        } catch (\Exception $e) {
            $this->attachStripeExceptions($e);
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

            // save platform data
            // $customer->setPlatformLastSync($customerStripe->updated);
            $customer->setPlatformConflict(false);
            $customer->setPlatformData($customerStripe->toArray());

            if (isset($data['tax_id'])) {
                $action = 'create';
                foreach ($customerStripe->tax_ids->getIterator() as $taxId) {
                    if ($taxId->type == $data['tax_id']['type']) {
                        if ($taxId->value == $data['tax_id']['value']) {
                            $action = 'none';
                        } else {
                            $action = 'update';
                            $deleteTaxId = $taxId->id;
                        }
                    }
                }

                if ($action == 'create') {
                    Customer::createTaxId($customerStripe->id, $data['tax_id']);
                } elseif ($action == 'update') {
                    Customer::deleteTaxId($customerStripe->id, $deleteTaxId);
                    Customer::createTaxId($customerStripe->id, $data['tax_id']);
                }
            }

            return $customerStripe;
        } catch (\Exception $e) {
            $this->attachStripeExceptions($e);
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
        } catch (\Exception $e) {
            $this->attachStripeExceptions($e);
        } finally {
            $customer->setPlatformId(null);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(CustomerInterface $customer)
    {
        $this->initStripe();

        /** @var Customer $customer */
        return Customer::retrieve([
            'id' => $customer->getPlatformId(),
        ]);
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
            $this->attachStripeExceptions($e);
        }
    }
}