<?php

namespace Softspring\CustomerBundle\Doctrine\EntityListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Platform\Adapter\CustomerAdapterInterface;
use Softspring\CustomerBundle\Platform\Exception\NotFoundInPlatform;

class StripeCustomerEntityListener
{
    /**
     * @var CustomerAdapterInterface
     */
    protected $customerAdapter;

    /**
     * CustomerEntityListener constructor.
     *
     * @param CustomerAdapterInterface $customerAdapter
     */
    public function __construct(CustomerAdapterInterface $customerAdapter)
    {
        $this->customerAdapter = $customerAdapter;
    }

    /**
     * @param CustomerInterface  $customer
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(CustomerInterface $customer, LifecycleEventArgs $eventArgs)
    {
        $this->customerAdapter->create($customer);
    }

    /**
     * @param CustomerInterface  $customer
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(CustomerInterface $customer, PreUpdateEventArgs $eventArgs)
    {
        if (!$customer->getPlatformId()) {
            $this->customerAdapter->create($customer);
        } else {
            $this->customerAdapter->update($customer);
        }
    }

    /**
     * @param CustomerInterface  $customer
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(CustomerInterface $customer, LifecycleEventArgs $eventArgs)
    {
        if ($customer->getPlatformId()) {
            try {
                $this->customerAdapter->delete($customer);
            } catch (NotFoundInPlatform $e) {
                // nothing to do, it's already deleted
            }
        }
    }
}