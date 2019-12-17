<?php

namespace Softspring\CustomerBundle\Manager;

use Softspring\CustomerBundle\Model\CustomerInterface;

interface SourceManagerInterface
{
    /**
     * @param CustomerInterface $customer
     * @param string            $sourceId
     *
     * @return array
     */
    public function getSource(CustomerInterface $customer, string $sourceId): array;
}