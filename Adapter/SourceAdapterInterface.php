<?php

namespace Softspring\CustomerBundle\Adapter;

use Softspring\CustomerBundle\Model\CustomerInterface;

interface SourceAdapterInterface extends PlatformAdapterInterface
{
    /**
     * @param CustomerInterface $customer
     * @param string            $sourceId
     *
     * @return array
     */
    public function getSource(CustomerInterface $customer, string $sourceId): array;
}