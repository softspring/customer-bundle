<?php

namespace Softspring\CustomerBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Softspring\CustomerBundle\Model\PlatformObjectInterface;
use Softspring\CustomerBundle\Model\PlatformObjectTrait;
use Softspring\CustomerBundle\Platform\PlatformInterface;

class PlatformDataTraitTest extends TestCase
{
    public function testTrait()
    {
        /** @var PlatformObjectInterface $trait */
        $trait = $this->getObjectForTrait(PlatformObjectTrait::class);

        $this->assertNull($trait->getPlatform());
        $this->assertNull($trait->getPlatformId());
        $this->assertNull($trait->getPlatformLastSync());
        $this->assertNull($trait->getPlatformData());
        $this->assertFalse($trait->isTestMode());
        $this->assertFalse($trait->isPlatformConflict());

        $trait->setPlatform(PlatformInterface::PLATFORM_STRIPE);
        $this->assertEquals(PlatformInterface::PLATFORM_STRIPE, $trait->getPlatform());

        $trait->setPlatformId('obj_test_id');
        $this->assertEquals('obj_test_id', $trait->getPlatformId());

        $now = new \DateTime('now');
        $trait->setPlatformLastSync($now);
        $this->assertEquals($now->format('Y-m-d H:i:s'), $trait->getPlatformLastSync()->format('Y-m-d H:i:s'));

        $data = ['test' => 'data'];
        $trait->setPlatformData($data);
        $this->assertEquals($data, $trait->getPlatformData());

        $trait->setTestMode(true);
        $this->assertTrue($trait->isTestMode());

        $trait->setPlatformConflict(true);
        $this->assertTrue($trait->isPlatformConflict());
    }
}
