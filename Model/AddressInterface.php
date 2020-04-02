<?php

namespace Softspring\CustomerBundle\Model;

interface AddressInterface extends PlatformObjectInterface
{
    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;
}