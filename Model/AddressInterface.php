<?php

namespace Softspring\CustomerBundle\Model;

use Softspring\DoctrineTemplates\Model\HCardInterface;

interface AddressInterface extends PlatformObjectInterface, HCardInterface
{
    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * @param CustomerInterface|null $customer
     */
    public function setCustomer(?CustomerInterface $customer): void;
}