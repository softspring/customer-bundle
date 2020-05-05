<?php

namespace Softspring\CustomerBundle\Platform;

use Softspring\CustomerBundle\Platform\Adapter\PlatformAdapterInterface;
use Softspring\CustomerBundle\Platform\Exception\PlatformException;
use Softspring\CustomerBundle\Platform\Exception\PlatformNotYetImplemented;

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

        throw new PlatformNotYetImplemented(-1, $this->name);
    }

    /**
     * @inheritDoc
     */
    public function get(string $adapter): PlatformAdapterInterface
    {
        if (!isset($this->adapters[$adapter])) {
            throw new PlatformException($this->platformId(), sprintf('Adapter %s does not exist', $adapter));
        }

        return $this->adapters[$adapter];
    }
}