<?php

namespace Softspring\CustomerBundle\Model;

use Doctrine\Common\Collections\Collection;
use Softspring\DoctrineTemplates\Model\NamedInterface;

interface CustomerInterface extends NamedInterface
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

    /**
     * @return Collection|SourceInterface[]
     */
    public function getSources(): Collection;

    /**
     * @param SourceInterface $source
     */
    public function addSource(SourceInterface $source): void;

    /**
     * @param SourceInterface $source
     */
    public function removeSource(SourceInterface $source): void;

    /**
     * @return SourceInterface|null
     */
    public function getDefaultSource(): ?SourceInterface;

    /**
     * @param SourceInterface|null $defaultSource
     */
    public function setDefaultSource(?SourceInterface $defaultSource): void;
}