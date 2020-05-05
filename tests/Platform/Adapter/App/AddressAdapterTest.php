<?php

namespace Softspring\CustomerBundle\Tests\Platform\Adapter\App;

use Softspring\CustomerBundle\Platform\Adapter\App\AddressAdapter;
use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Tests\Model\Examples\AddressExample;

class AddressAdapterTest extends TestCase
{
    public function testEmptyMethods()
    {
        $address = new AddressExample();
        $adapter = new AddressAdapter();
        $adapter->create($address);
        $adapter->get($address);
        $this->assertTrue(true);
    }
}
