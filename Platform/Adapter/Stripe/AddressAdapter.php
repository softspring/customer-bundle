<?php

namespace Softspring\CustomerBundle\Platform\Adapter\Stripe;

use Softspring\CustomerBundle\Model\AddressInterface;
use Softspring\CustomerBundle\Platform\Adapter\AddressAdapterInterface;

class AddressAdapter extends AbstractStripeAdapter implements AddressAdapterInterface
{
    /**
     * @inheritDoc
     */
    public function create(AddressInterface $address)
    {

    }

    /**
     * @inheritDoc
     */
    public function get(AddressInterface $address): array
    {

    }
}