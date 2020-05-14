<?php

namespace Softspring\CustomerBundle\Tests\Model;

use Softspring\CustomerBundle\Model\CustomerAddressesInterface;
use Softspring\CustomerBundle\Model\CustomerInterface;
use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Tests\Model\Examples\AddressExample;
use Softspring\CustomerBundle\Tests\Model\Examples\CustomerBaseExample;
use Softspring\CustomerBundle\Tests\Model\Examples\CustomerWithAddressesExample;
use Softspring\CustomerBundle\Tests\Model\Examples\SourceExample;

class CustomerTest extends TestCase
{
    public function testInterfaces()
    {
        $this->assertInstanceOf(CustomerInterface::class, new CustomerBaseExample());
        $this->assertInstanceOf(CustomerAddressesInterface::class, new CustomerWithAddressesExample());
    }

    public function testSources()
    {
        $customer = new CustomerBaseExample();

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
        $customer = new CustomerBaseExample();

        $customer->setTaxIdCountry('ES');
        $this->assertEquals('ES', $customer->getTaxIdCountry());

        $customer->setTaxIdNumber('00000000X');
        $this->assertEquals('00000000X', $customer->getTaxIdNumber());
    }

    public function testAddresses()
    {
        $customer = new CustomerWithAddressesExample();
        $address = new AddressExample();

        $this->assertCount(0, $customer->getAddresses());

        $customer->addAddress($address);
        $this->assertCount(1, $customer->getAddresses());
        $this->assertEquals($customer, $address->getCustomer());

        $customer->removeAddress($address);
        $this->assertCount(0, $customer->getAddresses());
    }
}
