<?php

namespace Softspring\CustomerBundle\Model;

use Doctrine\Common\Collections\Collection;

trait CustomerAddressesTrait
{
    /**
     * @var AddressInterface[]|Collection
     */
    protected $addresses;

    /**
     * @return Collection|AddressInterface[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param AddressInterface $address
     */
    public function addAddress(AddressInterface $address): void
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->setCustomer($this);
        }
    }

    /**
     * @param AddressInterface $address
     */
    public function removeAddress(AddressInterface $address): void
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }
    }
}