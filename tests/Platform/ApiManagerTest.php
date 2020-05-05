<?php

namespace Softspring\CustomerBundle\Tests\Platform;

use Softspring\CustomerBundle\Platform\Adapter\Stripe\CustomerAdapter;
use Softspring\CustomerBundle\Platform\ApiManager;
use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Platform\Exception\PlatformException;
use Softspring\CustomerBundle\Platform\Exception\PlatformNotYetImplemented;
use Softspring\CustomerBundle\Platform\PlatformInterface;

class ApiManagerTest extends TestCase
{
    public function testInvalidPlatform()
    {
        $this->expectException(PlatformNotYetImplemented::class);
        $apiManager = new ApiManager('app', []);
        $apiManager->platformId();
    }

    public function testStripe()
    {
        $apiManager = new ApiManager('stripe', []);

        $this->assertEquals(PlatformInterface::PLATFORM_STRIPE, $apiManager->platformId());
        $this->assertEquals('stripe', $apiManager->name());
    }

    public function testAdapters()
    {
        $customerAdapter = $this->createMock(CustomerAdapter::class);

        $apiManager = new ApiManager('stripe', [
            'customer' => $customerAdapter,
        ]);

        $this->assertEquals($customerAdapter, $apiManager->get('customer'));
    }

    public function testMissingAdapter()
    {
        $this->expectException(PlatformException::class);

        $customerAdapter = $this->createMock(CustomerAdapter::class);

        $apiManager = new ApiManager('stripe', [
            'customer' => $customerAdapter,
        ]);

        $apiManager->get('sources');
    }

    public function testTranslationTag()
    {
        $exception = new PlatformException(PlatformInterface::PLATFORM_APP, 'error_tag');
        $this->assertEquals('platform_error.app.error_tag', $exception->getTranslationTag());

        $exception = new PlatformException(PlatformInterface::PLATFORM_STRIPE, 'error_tag');
        $this->assertEquals('platform_error.stripe.error_tag', $exception->getTranslationTag());

        $exception = new PlatformException(-1, 'error_tag');
        $this->assertEquals('platform_error.unknown.error_tag', $exception->getTranslationTag());
    }
}
