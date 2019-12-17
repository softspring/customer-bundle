<?php

namespace Softspring\CustomerBundle\Adapter\Stripe;

use Softspring\CustomerBundle\Adapter\SourceAdapterInterface;
use Softspring\CustomerBundle\Exception\CustomerException;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Stripe\Customer;
use Stripe\Exception\InvalidRequestException;

class StripeSourceAdapter extends AbstractStripeAdapter implements SourceAdapterInterface
{
    /**
     * @inheritDoc
     */
    public function getSource(CustomerInterface $customer, string $sourceId): array
    {
        $this->initStripe();

        try {
            $data = Customer::retrieveSource($customer->getPlatformId(), $sourceId);

            return $data->toArray();
        } catch (InvalidRequestException $e) {
            throw new CustomerException('Invalid stripe request', 0, $e);
        } catch (\Exception $e) {
            throw new CustomerException('Unknown stripe exception', 0, $e);
        }
    }
}