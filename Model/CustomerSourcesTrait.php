<?php

namespace Softspring\CustomerBundle\Model;

use Doctrine\Common\Collections\Collection;

trait CustomerSourcesTrait
{
    /**
     * @var SourceInterface[]|Collection
     */
    protected $sources;

    /**
     * @var SourceInterface|null
     */
    protected $defaultSource;

    /**
     * @return Collection|SourceInterface[]
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

    /**
     * @param SourceInterface $source
     */
    public function addSource(SourceInterface $source): void
    {
        if (!$this->sources->contains($source)) {
            $this->sources->add($source);
            $source->setCustomer($this);
        }
    }

    /**
     * @param SourceInterface $source
     */
    public function removeSource(SourceInterface $source): void
    {
        if ($this->sources->contains($source)) {
            $this->sources->removeElement($source);
        }
    }

    /**
     * @return SourceInterface|null
     */
    public function getDefaultSource(): ?SourceInterface
    {
        return $this->defaultSource;
    }

    /**
     * @param SourceInterface|null $defaultSource
     */
    public function setDefaultSource(?SourceInterface $defaultSource): void
    {
        $this->defaultSource = $defaultSource;
    }
}