<?php

namespace Softspring\CustomerBundle\Tests\Platform\Adapter\App;

use Softspring\CustomerBundle\Platform\Adapter\App\CustomerAdapter;
use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Tests\Model\Examples\CustomerBaseExample;

class CustomerAdapterTest extends TestCase
{
    public function testEmptyMethods()
    {
        $customer = new CustomerBaseExample();
        $adapter = new CustomerAdapter();
        $adapter->create($customer);
        $adapter->delete($customer);
        $adapter->update($customer);
        $adapter->get($customer);
        $this->assertTrue(true);
    }
}
