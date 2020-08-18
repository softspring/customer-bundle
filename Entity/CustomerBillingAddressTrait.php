<?php

namespace Softspring\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\CustomerBundle\Model\AddressInterface;
use Softspring\CustomerBundle\Model\CustomerBillingAddressTrait as CustomerBillingAddressTraitModel;

trait CustomerBillingAddressTrait
{
    use CustomerBillingAddressTraitModel;

    /**
     * @var AddressInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\CustomerBundle\Model\AddressInterface")
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $billingAddress;
}