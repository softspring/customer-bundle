<?php

namespace Softspring\CustomerBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Customer implements CustomerInterface
{
    use CustomerTaxIdTrait;
    use CustomerSourcesTrait;

    public function __construct()
    {
        $this->sources = new ArrayCollection();
    }
}