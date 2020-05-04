<?php

namespace Softspring\CustomerBundle\Tests\Model;

use Softspring\CustomerBundle\Model\CustomerInterface;
use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Model\PlatformObjectInterface;
use Softspring\CustomerBundle\Tests\Model\Examples\CustomerExample;
use Softspring\CustomerBundle\Tests\Model\Examples\SourceExample;

class CustomerTest extends TestCase
{
    public function testInterfaces()
    {
        $this->assertInstanceOf(CustomerInterface::class, new CustomerExample());
        $this->assertInstanceOf(PlatformObjectInterface::class, new CustomerExample());
    }

    public function testSources()
    {
        $customer = new CustomerExample();

        $this->assertNull($customer->getDefaultSource());
        $this->assertEquals(0, $customer->getSources()->count());

        $source = new SourceExample();
        $customer->addSource($source);
        $this->assertEquals(1, $customer->getSources()->count());
        $this->assertEquals($customer, $source->getCustomer());

        $customer->setDefaultSource($source);
        $this->assertEquals($source, $customer->getDefaultSource());

        $customer->removeSource($source);
        $this->assertEquals(0, $customer->getSources()->count());
    }

    public function testTaxId()
    {
        $customer = new CustomerExample();

        $customer->setTaxIdCountry('ES');
        $this->assertEquals('ES', $customer->getTaxIdCountry());

        $customer->setTaxIdNumber('00000000X');
        $this->assertEquals('00000000X', $customer->getTaxIdNumber());
    }
}
