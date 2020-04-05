<?php

namespace Softspring\CustomerBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Softspring\DoctrineTemplates\Entity\Traits\Named;

abstract class Customer implements CustomerInterface
{
    use Named;
    use CustomerTaxIdTrait;
    use CustomerAddressesTrait;
    use CustomerSourcesTrait;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->sources = new ArrayCollection();
    }
}