<?php

namespace Softspring\CustomerBundle\Model;

use Doctrine\Common\Collections\Collection;

interface CustomerAddressesInterface
{
    /**
     * @return Collection|AddressInterface[]
     */
    public function getAddresses(): Collection;

    /**
     * @param AddressInterface $address
     */
    public function addAddress(AddressInterface $address): void;

    /**
     * @param AddressInterface $address
     */
    public function removeAddress(AddressInterface $address): void;
}