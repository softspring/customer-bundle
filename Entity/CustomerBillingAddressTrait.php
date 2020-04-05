<?php

namespace Softspring\CustomerBundle\Entity;

use Softspring\CustomerBundle\Model\AddressInterface;

trait CustomerBillingAddressTrait
{
    /**
     * @var AddressInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\CustomerBundle\Model\AddressInterface")
     */
    protected $billingAddress;

    /**
     * @return AddressInterface|null
     */
    public function getBillingAddress(): ?AddressInterface
    {
        return $this->billingAddress;
    }

    /**
     * @param AddressInterface|null $billingAddress
     */
    public function setBillingAddress(?AddressInterface $billingAddress): void
    {
        if ($billingAddress) {
            $this->addAddress($billingAddress);
        }

        $this->billingAddress = $billingAddress;
    }
}