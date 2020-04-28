<?php

namespace Softspring\CustomerBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\CustomerBundle\Model\CustomerInterface;

interface CustomerManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @return CustomerInterface
     */
    public function createEntity();

    /**
     * @param CustomerInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param CustomerInterface $entity
     */
    public function deleteEntity($entity): void;

    // public function createInPlatform(CustomerInterface $customer): void;

    // public function addCard(CustomerInterface $customer, string $token, bool $setDefault = false): ?string;
}