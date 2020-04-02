<?php

namespace Softspring\CustomerBundle\Platform\Adapter;

use Softspring\CustomerBundle\Event\NotifyEvent;
use Symfony\Component\HttpFoundation\Request;

interface NotifyAdapterInterface extends PlatformAdapterInterface
{
    public function createEvent(Request $request): NotifyEvent;
}