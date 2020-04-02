<?php

namespace Softspring\CustomerBundle\Platform\Adapter\App;

use Softspring\CustomerBundle\Event\NotifyEvent;
use Softspring\CustomerBundle\Platform\Adapter\NotifyAdapterInterface;
use Symfony\Component\HttpFoundation\Request;

class NotifyAdapter implements NotifyAdapterInterface
{
    public function createEvent(Request $request): NotifyEvent
    {
        // TODO: Implement createEvent() method.
    }

}