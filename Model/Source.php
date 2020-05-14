<?php

namespace Softspring\CustomerBundle\Model;

abstract class Source implements SourceInterface
{
    /**
     * @var int|null
     */
    protected $type;

    /**
     * @var CustomerInterface|null
     */
    protected $customer;

    /**
     * @var string|null
     */
    protected $platformToken;

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     */
    public function setType(?int $type): void
    {
        $this->type = $type;
    }

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

    /**
     * @return string|null
     */
    public function getPlatformToken(): ?string
    {
        return $this->platformToken;
    }

    /**
     * @param string|null $platformToken
     */
    public function setPlatformToken(?string $platformToken): void
    {
        $this->platformToken = $platformToken;
    }
}