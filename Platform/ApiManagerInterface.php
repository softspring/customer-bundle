<?php

namespace Softspring\CustomerBundle\Platform;

use Softspring\CustomerBundle\Platform\Adapter\PlatformAdapterInterface;

interface ApiManagerInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return int
     */
    public function platformId(): int;

    /**
     * @param string $adapter
     *
     * @return PlatformAdapterInterface
     */
    public function get(string $adapter): PlatformAdapterInterface;
}