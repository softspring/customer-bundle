<?php

namespace Softspring\CustomerBundle\Model;

use Softspring\CustomerBundle\Model\AddressInterface;

trait CustomerBillingAddressTrait
{
    /**
     * @var AddressInterface|null
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