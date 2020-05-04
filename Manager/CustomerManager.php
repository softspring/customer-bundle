<?php

namespace Softspring\CustomerBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\CrudlBundle\Manager\CrudlEntityManagerTrait;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Platform\ApiManagerInterface;

class CustomerManager implements CustomerManagerInterface
{
    use CrudlEntityManagerTrait;

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
        $class = $this->getEntityClassReflection()->name;

        /** @var CustomerInterface $entity */
        $entity = new $class;
        $entity->setPlatform($this->api->platformId());

        return $entity;
    }
}