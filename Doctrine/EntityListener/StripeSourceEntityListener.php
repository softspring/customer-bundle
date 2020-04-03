<?php

namespace Softspring\CustomerBundle\Doctrine\EntityListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Softspring\CustomerBundle\Model\SourceInterface;
use Softspring\CustomerBundle\Platform\Adapter\CustomerAdapterInterface;
use Softspring\CustomerBundle\Platform\Adapter\SourceAdapterInterface;
use Softspring\CustomerBundle\Platform\Exception\NotFoundInPlatform;

class StripeSourceEntityListener
{
    /**
     * @var CustomerAdapterInterface
     */
    protected $customerAdapter;

    /**
     * @var SourceAdapterInterface
     */
    protected $sourceAdapter;

    /**
     * StripeSourceEntityListener constructor.
     *
     * @param CustomerAdapterInterface $customerAdapter
     * @param SourceAdapterInterface   $sourceAdapter
     */
    public function __construct(CustomerAdapterInterface $customerAdapter, SourceAdapterInterface $sourceAdapter)
    {
        $this->customerAdapter = $customerAdapter;
        $this->sourceAdapter = $sourceAdapter;
    }

    /**
     * @param SourceInterface    $source
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(SourceInterface $source, LifecycleEventArgs $eventArgs)
    {
        $this->sourceAdapter->create($source);
    }

    /**
     * @param SourceInterface    $source
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(SourceInterface $source, PreUpdateEventArgs $eventArgs)
    {
//        if (!$source->getPlatformId()) {
//            $this->sourceAdapter->create($source);
//        } else {
//            $this->sourceAdapter->update($source);
//        }
    }

    /**
     * @param SourceInterface    $source
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(SourceInterface $source, LifecycleEventArgs $eventArgs)
    {
//        if ($source->getPlatformId()) {
//            try {
//                $this->sourceAdapter->delete($source);
//            } catch (NotFoundInPlatform $e) {
//                // nothing to do, it's already deleted
//            }
//        }
    }
}