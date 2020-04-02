<?php

namespace Softspring\CustomerBundle\Platform\Adapter\App;

use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Platform\Adapter\SourceAdapterInterface;

class SourceAdapter implements SourceAdapterInterface
{
    public function getSource(CustomerInterface $customer, string $sourceId): array
    {
        // TODO: Implement getSource() method.
    }

}