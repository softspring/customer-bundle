<?php

namespace Softspring\CustomerBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\CustomerBundle\Model\CustomerAddressesTrait as CustomerAddressesTraitModel;
use Softspring\CustomerBundle\Model\AddressInterface;

trait CustomerAddressesTrait
{
    use CustomerAddressesTraitModel;

    /**
     * @var AddressInterface[]|Collection
     * @ORM\OneToMany(targetEntity="Softspring\CustomerBundle\Model\AddressInterface", mappedBy="customer", cascade={"all"})
     */
    protected $addresses;
}