<?php

namespace Softspring\CustomerBundle;

interface PlatformInterface
{
    const PLATFORM_NONE = 0;
    const PLATFORM_STRIPE = 1;
    const PLATFORM_PAYPAL = 2;
}