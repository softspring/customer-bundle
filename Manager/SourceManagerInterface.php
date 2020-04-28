<?php

namespace Softspring\CustomerBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\CustomerBundle\Model\SourceInterface;

interface SourceManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @return SourceInterface
     */
    public function createEntity();

    /**
     * @param SourceInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param SourceInterface $entity
     */
    public function deleteEntity($entity): void;
}