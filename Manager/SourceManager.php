<?php

namespace Softspring\CustomerBundle\Manager;

use Softspring\CustomerBundle\Model\CustomerInterface;

class SourceManager implements SourceManagerInterface
{
    /**
     * @var ApiManagerInterface
     */
    protected $apiManager;

    /**
     * SourceManager constructor.
     *
     * @param ApiManagerInterface $apiManager
     */
    public function __construct(ApiManagerInterface $apiManager)
    {
        $this->apiManager = $apiManager;
    }

    /**
     * @inheritDoc
     */
    public function getSource(CustomerInterface $customer, string $sourceId): array
    {
        $stripeData = $this->apiManager->get('source')->getSource($customer, $sourceId);

        return $stripeData;
    }
}