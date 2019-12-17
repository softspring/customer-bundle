<?php

namespace Softspring\CustomerBundle\Adapter;

use Softspring\CustomerBundle\Event\NotifyEvent;
use Symfony\Component\HttpFoundation\Request;

interface NotifyAdapterInterface extends PlatformAdapterInterface
{
    public function createEvent(Request $request): NotifyEvent;
}