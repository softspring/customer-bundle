<?php

namespace Softspring\CustomerBundle\Tests\Model\Examples;

use Softspring\CustomerBundle\Model\Customer;
use Softspring\CustomerBundle\Model\PlatformObjectTrait;

class CustomerBaseExample extends Customer
{
    use PlatformObjectTrait;
}