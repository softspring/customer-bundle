<?php

namespace Softspring\CustomerBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\CustomerBundle\Model\AddressInterface;

interface AddressManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @return AddressInterface
     */
    public function createEntity();

    /**
     * @param AddressInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param AddressInterface $entity
     */
    public function deleteEntity($entity): void;
}