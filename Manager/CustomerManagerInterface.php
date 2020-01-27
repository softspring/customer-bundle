<?php

namespace Softspring\CustomerBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\CustomerBundle\Model\CustomerInterface;

interface CustomerManagerInterface extends CrudlEntityManagerInterface
{
    public function createInPlatform(CustomerInterface $customer): void;

    public function addCard(CustomerInterface $customer, string $token, bool $setDefault = false): ?string;
}