<?php

namespace Softspring\CustomerBundle\Tests\Model\Examples;

use Softspring\CustomerBundle\Model\Customer;
use Softspring\CustomerBundle\Model\CustomerAddressesInterface;
use Softspring\CustomerBundle\Model\CustomerAddressesTrait;

class CustomerWithAddressesExample extends Customer implements CustomerAddressesInterface
{
    use CustomerAddressesTrait;
}