<?php

namespace Softspring\CustomerBundle\Model;

interface SourceInterface extends PlatformObjectInterface
{
    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;
}