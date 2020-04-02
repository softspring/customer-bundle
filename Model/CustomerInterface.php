<?php

namespace Softspring\CustomerBundle\Model;

interface CustomerInterface extends PlatformObjectInterface
{
    /**
     * @return string|null
     */
    public function getTaxIdNumber(): ?string;

    /**
     * @param string|null $taxIdNumber
     */
    public function setTaxIdNumber(?string $taxIdNumber): void;

    /**
     * @return string|null
     */
    public function getTaxIdCountry(): ?string;

    /**
     * @param string|null $taxIdCountry
     */
    public function setTaxIdCountry(?string $taxIdCountry): void;
}