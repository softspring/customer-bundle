<?php

namespace Softspring\CustomerBundle\Tests\Platform\Adapter\App;

use Softspring\CustomerBundle\Platform\Adapter\App\SourceAdapter;
use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Tests\Model\Examples\SourceExample;

class SourceAdapterTest extends TestCase
{
    public function testEmptyMethods()
    {
        $source = new SourceExample();
        $adapter = new SourceAdapter();
        $adapter->create($source);
        $adapter->get($source);
        $this->assertTrue(true);
    }
}
