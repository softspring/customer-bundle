<?php

namespace Softspring\CustomerBundle\Model;

interface SourceAliasedInterface
{
    /**
     * @return string|null
     */
    public function getAlias(): ?string;

    /**
     * @param string|null $alias
     */
    public function setAlias(?string $alias): void;
}