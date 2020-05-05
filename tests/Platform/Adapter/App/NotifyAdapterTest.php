<?php

namespace Softspring\CustomerBundle\Tests\Platform\Adapter\App;

use Softspring\CustomerBundle\Platform\Adapter\App\NotifyAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class NotifyAdapterTest extends TestCase
{
    public function testEmptyMethods()
    {
        $adapter = new NotifyAdapter();
        $adapter->createEvent(new Request());
        $this->assertTrue(true);
    }
}
