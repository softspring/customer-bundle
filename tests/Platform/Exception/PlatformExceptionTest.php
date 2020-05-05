<?php

namespace Softspring\CustomerBundle\Tests\Platform\Exception;

use Softspring\CustomerBundle\Platform\Exception\PlatformException;
use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Platform\PlatformInterface;

class PlatformExceptionTest extends TestCase
{
    public function testThrowable()
    {
        $this->assertInstanceOf(\Throwable::class, new PlatformException(-1, ''));
    }

    public function testBasicMethods()
    {
        $exception = new PlatformException(PlatformInterface::PLATFORM_STRIPE, 'stripe_some_error');

        $this->assertEquals(PlatformInterface::PLATFORM_STRIPE, $exception->getPlatformId());
        $this->assertEquals('stripe_some_error', $exception->getPlatformError());
    }
}
