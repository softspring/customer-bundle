<?php

namespace Softspring\CustomerBundle\Model;

use Softspring\DoctrineTemplates\Entity\Traits\HCardTrait;

abstract class Address implements AddressInterface
{
    use PlatformObjectTrait;
    use HCardTrait;

    /**
     * @var CustomerInterface|null
     */
    protected $customer;

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface|null $customer
     */
    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }
}