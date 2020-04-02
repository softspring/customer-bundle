<?php

namespace Softspring\CustomerBundle\Model;

trait CustomerTaxIdTrait
{
    /**
     * @var string|null
     */
    protected $taxIdNumber;

    /**
     * @var string|null
     */
    protected $taxIdCountry;

    /**
     * @return string|null
     */
    public function getTaxIdNumber(): ?string
    {
        return $this->taxIdNumber;
    }

    /**
     * @param string|null $taxIdNumber
     */
    public function setTaxIdNumber(?string $taxIdNumber): void
    {
        $this->taxIdNumber = $taxIdNumber;
    }

    /**
     * @return string|null
     */
    public function getTaxIdCountry(): ?string
    {
        return $this->taxIdCountry;
    }

    /**
     * @param string|null $taxIdCountry
     */
    public function setTaxIdCountry(?string $taxIdCountry): void
    {
        $this->taxIdCountry = $taxIdCountry;
    }
}