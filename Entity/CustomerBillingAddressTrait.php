<?php

namespace Softspring\CustomerBundle\Entity;

use Softspring\CustomerBundle\Model\AddressInterface;
use Softspring\CustomerBundle\Model\CustomerBillingAddressTrait as CustomerBillingAddressTraitModel;

trait CustomerBillingAddressTrait
{
    use CustomerBillingAddressTraitModel;

    /**
     * @var AddressInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\CustomerBundle\Model\AddressInterface")
     */
    protected $billingAddress;
}