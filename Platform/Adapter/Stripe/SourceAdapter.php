<?php

namespace Softspring\CustomerBundle\Platform\Adapter\Stripe;

use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Platform\Adapter\SourceAdapterInterface;
use Softspring\CustomerBundle\Platform\Exception\CustomerException;
use Stripe\Customer;
use Stripe\Exception\InvalidRequestException;

class SourceAdapter extends AbstractStripeAdapter implements SourceAdapterInterface
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
            throw new CustomerException($customer->getPlatformId(), '', 'Invalid stripe request', 0, $e);
        } catch (\Exception $e) {
            throw new CustomerException($customer->getPlatformId(), '', 'Unknown stripe exception', 0, $e);
        }
    }
}