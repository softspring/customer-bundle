<?php

namespace Softspring\CustomerBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Model\SourceInterface;
use Softspring\CustomerBundle\Tests\Model\Examples\CustomerBaseExample;
use Softspring\CustomerBundle\Tests\Model\Examples\SourceExample;

class SourceTest extends TestCase
{
    public function testInterfaces()
    {
        $this->assertInstanceOf(SourceInterface::class, new SourceExample());
    }

    public function testSources()
    {
        $source = new SourceExample();

        $this->assertNull($source->getType());
        $this->assertNull($source->getCustomer());
        $this->assertNull($source->getPlatformToken());

        $source->setType(SourceInterface::TYPE_CARD);
        $this->assertEquals(SourceInterface::TYPE_CARD, $source->getType());

        $customer = new CustomerBaseExample();
        $source->setCustomer($customer);
        $this->assertEquals($customer, $source->getCustomer());

        $source->setPlatformToken('test_token');
        $this->assertEquals('test_token', $source->getPlatformToken());
    }
}
