<?php

namespace Softspring\CustomerBundle\Tests\Platform\Adapter\Stripe;

use PHPUnit\Framework\MockObject\MockObject;
use Softspring\CustomerBundle\Platform\Exception\NotFoundInPlatform;
use Softspring\CustomerBundle\Platform\Adapter\Stripe\CustomerAdapter;
use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Platform\Exception\PlatformException;
use Softspring\CustomerBundle\Tests\Model\Examples\AddressExample;
use Softspring\CustomerBundle\Tests\Model\Examples\CustomerBaseExample;
use Softspring\CustomerBundle\Tests\Model\Examples\CustomerFullExample;
use Stripe\Collection;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Customer;
use Stripe\TaxId;

class CustomerAdapterTest extends TestCase
{
    /**
     * @var CustomerAdapter
     */
    protected $adapter;

    protected function setUp(): void
    {
        $this->adapter = $this->getMockBuilder(CustomerAdapter::class)
            ->setConstructorArgs(['sk_test_xxx', null, null])
            ->onlyMethods(['initStripe', 'stripeClientCreate', 'stripeClientRetrieve', 'stripeClientTaxIdCreate', 'stripeClientTaxIdDelete'])
            ->getMock();
    }

    public function testGetExisting()
    {
        $customer = new CustomerBaseExample();
        $customer->setPlatformId('cus_test');

        $this->adapter->method('stripeClientRetrieve')->will($this->returnValue($this->createStripeCustomerObject([
            'id' => 'cus_test',
            'livemode' => false,
            'created' => ($created = new \DateTime('now'))->format('U'),
        ])));

        $this->adapter->get($customer);
        $this->assertEquals('cus_test', $customer->getPlatformId());
        $this->assertEquals(true, $customer->isTestMode());
        $this->assertEquals(false, $customer->isPlatformConflict());
        $this->assertEquals($created->format('Y-m-d H:i:s'), $customer->getPlatformLastSync()->format('Y-m-d H:i:s'));
    }

    public function testGetMissing()
    {
        $this->expectException(NotFoundInPlatform::class);

        $customer = new CustomerBaseExample();
        $customer->setPlatformId('cus_test_not_existing');

        $e = new InvalidRequestException();
        $e->setStripeCode('resource_missing');
        $this->adapter->method('stripeClientRetrieve')->will($this->throwException($e));

        $this->adapter->get($customer);
    }

    public function testCreate()
    {
        $customer = new CustomerBaseExample();
        $customer->setTaxIdCountry('ES');
        $customer->setTaxIdNumber('000000000X');

        $taxIdMockObject = $this->createStripeTaxIdObject([
            'id' => 'txi_test',
            'country' => 'ES',
            'livemode' => false,
            'created' => ($created = new \DateTime('now'))->format('U'),
            'customer' => 'cus_test',
            'type' => 'eu_vat',
            'value' => '000000000X',
            'verification' => [
                'status' => 'pending',
                'verified_address' => null,
                'verified_name' => null,
            ],
        ]);

        $this->adapter->method('stripeClientCreate')->will($this->returnValue($this->createStripeCustomerObject([
            'id' => 'cus_test',
            'livemode' => false,
            'created' => ($created = new \DateTime('now'))->format('U'),
            'tax_ids' => $this->createStripeCollectionObject([$taxIdMockObject]),
        ])));

        $this->adapter->method('stripeClientTaxIdCreate')->will($this->returnValue($taxIdMockObject));

        $this->adapter->create($customer);
        $this->assertEquals('cus_test', $customer->getPlatformId());
        $this->assertEquals(true, $customer->isTestMode());
        $this->assertEquals(false, $customer->isPlatformConflict());
        $this->assertEquals($created->format('Y-m-d H:i:s'), $customer->getPlatformLastSync()->format('Y-m-d H:i:s'));
    }

    public function testCreateNotSpain()
    {
        $customer = new CustomerBaseExample();
        $customer->setTaxIdCountry('IT');
        $customer->setTaxIdNumber('000000000X');

        $this->adapter->method('stripeClientCreate')->will($this->returnValue($this->createStripeCustomerObject([
            'id' => 'cus_test',
            'livemode' => false,
            'created' => ($created = new \DateTime('now'))->format('U'),
            'tax_ids' => $this->createStripeCollectionObject([]),
        ])));

        $this->adapter->method('stripeClientTaxIdCreate')->will($this->returnValue($this->createStripeTaxIdObject([
            'id' => 'tax',
        ])));

        $this->adapter->create($customer);
        $this->assertEquals('cus_test', $customer->getPlatformId());
        $this->assertEquals(true, $customer->isTestMode());
        $this->assertEquals(false, $customer->isPlatformConflict());
        $this->assertEquals($created->format('Y-m-d H:i:s'), $customer->getPlatformLastSync()->format('Y-m-d H:i:s'));
    }

    public function testCreateWithError()
    {
        $this->expectException(PlatformException::class);

        $customer = new CustomerBaseExample();
        $customer->setPlatformId('cus_test');

        $e = new ApiConnectionException();
        $this->adapter->method('stripeClientCreate')->will($this->throwException($e));

        $this->adapter->create($customer);
    }

    public function testCreateFull()
    {
        $customer = new CustomerFullExample();
        $customer->setTaxIdCountry('ES');
        $customer->setTaxIdNumber('000000000X');
        $customer->setEmail('test@example.com');
        $address = new AddressExample();
        $address->setName('Juan');
        $address->setSurname('González Pérez');
        $address->setStreetAddress('C/ Gran Vía 1');
        $address->setExtendedAddress('Piso 66, puerta Z');
        $address->setPostalCode('28000');
        $address->setLocality('Zaragoza');
        $address->setRegion('Zaragoza');
        $address->setCountryCode('ES');
        $address->setTel('9001231234');
        $customer->setBillingAddress($address);

        $this->adapter->method('stripeClientCreate')->will($this->returnValue($this->createStripeCustomerObject([
            'id' => 'cus_test',
            'livemode' => false,
            'created' => ($created = new \DateTime('now'))->format('U'),
            'tax_ids' => $this->createStripeCollectionObject([]),
        ])));

        $this->adapter->method('stripeClientTaxIdCreate')->will($this->returnValue($this->createStripeTaxIdObject([
            'id' => 'tax',
        ])));

        $this->adapter->create($customer);
        $this->assertEquals('cus_test', $customer->getPlatformId());
        $this->assertEquals(true, $customer->isTestMode());
        $this->assertEquals(false, $customer->isPlatformConflict());
        $this->assertEquals($created->format('Y-m-d H:i:s'), $customer->getPlatformLastSync()->format('Y-m-d H:i:s'));
    }

    public function testDelete()
    {
        $customer = new CustomerBaseExample();
        $customer->setPlatformId('cus_test');

        $object = $this->createStripeCustomerObject([
            'id' => 'cus_test',
            'livemode' => false,
            'created' => ($created = new \DateTime('now'))->format('U'),
        ]);

        $object->expects($this->once())->method('delete');

        $this->adapter->method('stripeClientRetrieve')->will($this->returnValue($object));

        $this->adapter->delete($customer);
    }

    public function testDeleteWithError()
    {
        $this->expectException(PlatformException::class);

        $customer = new CustomerBaseExample();
        $customer->setPlatformId('cus_test');

        $e = new ApiConnectionException();
        $this->adapter->method('stripeClientRetrieve')->will($this->throwException($e));

        $this->adapter->delete($customer);
    }

    public function testUpdate()
    {
        $customer = new CustomerBaseExample();
        $customer->setPlatformId('cus_test');

        $object = $this->createStripeCustomerObject([
            'id' => 'cus_test',
            'livemode' => false,
            'created' => ($created = new \DateTime('now'))->format('U'),
        ]);

        $object->expects($this->once())->method('save');

        $this->adapter->method('stripeClientRetrieve')->will($this->returnValue($object));

        $this->adapter->update($customer);
    }

    public function testUpdateMissing()
    {
        $this->expectException(NotFoundInPlatform::class);

        $customer = new CustomerBaseExample();
        $customer->setPlatformId('cus_test_not_existing');

        $e = new InvalidRequestException();
        $e->setStripeCode('resource_missing');
        $this->adapter->method('stripeClientRetrieve')->will($this->throwException($e));

        $this->adapter->update($customer);
    }


    /**
     * @param array $params
     *
     * @return Customer|MockObject
     */
    protected function createStripeCustomerObject(array $params)
    {
        $stripeCustomer = $this->getMockBuilder(Customer::class)->getMock();
        $params['object'] = 'customer';

        $stripeCustomer->method('__get')->willReturnCallback(function ($param) use ($params) {
            return $params[$param];
        });

        return $stripeCustomer;
    }

    /**
     * @param array $params
     *
     * @return Customer|MockObject
     */
    protected function createStripeTaxIdObject(array $params)
    {
        $stripeCustomer = $this->getMockBuilder(TaxId::class)->getMock();
        $params['object'] = 'tax_id';

        $stripeCustomer->method('__get')->willReturnCallback(function ($param) use ($params) {
            return $params[$param];
        });

        return $stripeCustomer;
    }

    protected function createStripeCollectionObject(array $objects, bool $hasMore = false)
    {
        $stripeCollection = $this->getMockBuilder(Collection::class)->getMock();

        $stripeCollection->method('getIterator')->willReturn(new \ArrayIterator($objects));

        $params = [
            'object' => 'list',
            'has_more' => $hasMore,
        ];

        $stripeCollection->method('__get')->willReturnCallback(function ($param) use ($params) {
            return $params[$param];
        });

        return $stripeCollection;
    }
}