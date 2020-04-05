<?php

namespace Softspring\CustomerBundle\Model;

interface CustomerBillingAddressInterface
{
    /**
     * @return AddressInterface|null
     */
    public function getBillingAddress(): ?AddressInterface;

    /**
     * @param AddressInterface|null $billingAddress
     */
    public function setBillingAddress(?AddressInterface $billingAddress): void;
}