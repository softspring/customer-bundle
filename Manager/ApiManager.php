<?php

namespace Softspring\CustomerBundle\Manager;

use Softspring\CustomerBundle\Adapter\PlatformAdapterInterface;
use Softspring\CustomerBundle\PlatformInterface;

class ApiManager implements ApiManagerInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var PlatformAdapterInterface[]
     */
    protected $adapters;

    /**
     * ApiManager constructor.
     *
     * @param string $name
     * @param array  $adapters
     */
    public function __construct(string $name, array $adapters)
    {
        $this->name = $name;
        $this->adapters = $adapters;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function platformId(): int
    {
        switch ($this->name) {
            case 'stripe':
                return PlatformInterface::PLATFORM_STRIPE;
        }

        throw new \Exception('Not valid or implemented platform');
    }

    /**
     * @inheritDoc
     */
    public function get(string $adapter): PlatformAdapterInterface
    {
        return $this->adapters[$adapter];
    }
}