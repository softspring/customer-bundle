<?php

namespace Softspring\CustomerBundle\Platform;

interface PlatformInterface
{
    /**
     * @deprecated use PlatformInterface::PLATFORM_APP
     */
    const PLATFORM_NONE = 0;
    const PLATFORM_APP = 0;
    const PLATFORM_STRIPE = 1;
}