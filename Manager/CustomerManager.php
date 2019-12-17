<?php

namespace Softspring\CustomerBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\AdminBundle\Manager\AdminEntityManagerTrait;
use Softspring\CustomerBundle\Model\CustomerInterface;

class CustomerManager implements CustomerManagerInterface
{
    use AdminEntityManagerTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var ApiManagerInterface
     */
    protected $api;

    /**
     * CustomerManager constructor.
     * @param EntityManagerInterface $em
     * @param ApiManagerInterface $api
     */
    public function __construct(EntityManagerInterface $em, ApiManagerInterface $api)
    {
        $this->em = $em;
        $this->api = $api;
    }

    public function getTargetClass(): string
    {
        return CustomerInterface::class;
    }

    public function createEntity()
    {
        $metadata = $this->em->getClassMetadata($this->getClass());
        $class = $metadata->getReflectionClass()->name;

        /** @var CustomerInterface $entity */
        $entity = new $class;
        $entity->setPlatform($this->api->platformId());

        return $entity;
    }

    public function createInPlatform(CustomerInterface $customer): void
    {
        if ($customer->getPlatformId()) {
            return;
        }

        $customer->setPlatform($this->api->platformId());
        $customer->setPlatformId($this->api->get('customer')->create($customer));

        // TODO $customer->setTestMode(true);

        $this->em->persist($customer);
        $this->em->flush();
    }

    public function addCard(CustomerInterface $customer, string $token, bool $setDefault = false): ?string
    {
        if (!$customer->getPlatformId()) {
            return null; // TODO exception
        }

        $this->api->get('customer')->addCard($customer, $token);

        return $this->api->get('customer')->getData($customer)->default_source;

        // TODO store default source
    }
}