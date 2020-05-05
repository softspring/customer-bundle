<?php

namespace Softspring\CustomerBundle\Model;

trait SourceAliasedTrait
{
    /**
     * @var string|null
     */
    protected $alias;

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     */
    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }
}