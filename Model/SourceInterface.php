<?php

namespace Softspring\CustomerBundle\Model;

interface SourceInterface
{
    const TYPE_CARD = 1;
    const TYPE_BANK_ACCOUNT = 2;

    /**
     * @return int|null
     */
    public function getType(): ?int;

    /**
     * @param int|null $type
     */
    public function setType(?int $type): void;

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * @param CustomerInterface|null $customer
     */
    public function setCustomer(?CustomerInterface $customer): void;

    /**
     * @return string|null
     */
    public function getPlatformToken(): ?string;

    /**
     * @param string|null $platformToken
     */
    public function setPlatformToken(?string $platformToken): void;
}