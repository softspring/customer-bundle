<?php

namespace Softspring\CustomerBundle\Adapter\Stripe;

use Softspring\CustomerBundle\Exception\PlatformException;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Adapter\CustomerAdapterInterface;
use Stripe\Card;
use Stripe\Customer;
use Stripe\Invoice;

class StripeCustomerAdapter extends AbstractStripeAdapter implements CustomerAdapterInterface
{
    /**
     * @inheritDoc
     */
    public function create(CustomerInterface $customer): string
    {
        $this->initStripe();

        $data = [
            'email' => $customer->getEmail(),
        ];

        // 'business_vat_id' => $account->getVatNumber(),
        // 'shipping' => [
        //     'name' => $account->getCompanyName(),
        //     'address' => [
        //         'line1' => $account->getAddress(),
        //         'postal_code' => $account->getZipCode(),
        //         'country' => $account->getCountry(),
        //     ],


        $customerId = Customer::create($data)->id;

        $this->logger->info(sprintf('Stripe created customer %s', $customerId));

        return $customerId;
    }

    /**
     * @inheritDoc
     */
    public function getData(CustomerInterface $client)
    {
        $this->initStripe();

        /** @var Customer $customer */
        return Customer::retrieve([
            'id' => $client->getPlatformId(),
        ]);
    }

    /**
     * @param CustomerInterface $customer
     * @param string            $token
     *
     * @return array|object|Card
     * @throws PlatformException
     */
    public function addCard(CustomerInterface $customer, string $token)
    {
        try {
            $customer = $this->getData($customer);

            /** @var Card $source */
            $source = $customer->sources->create(['source' => $token]);

            $customer->default_source = $source;
            $customer->save();

            return $source;
        } catch (\Exception $e) {
            $this->attachStripeExceptions($e);
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
            $this->attachStripeExceptions($e);
        }
    }
}