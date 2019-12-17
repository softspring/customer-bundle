<?php

namespace Softspring\CustomerBundle\Manager;

use Softspring\AdminBundle\Manager\AdminEntityManagerInterface;
use Softspring\CustomerBundle\Model\CustomerInterface;

interface CustomerManagerInterface extends AdminEntityManagerInterface
{
    public function createInPlatform(CustomerInterface $customer): void;

    public function addCard(CustomerInterface $customer, string $token, bool $setDefault = false): ?string;
}