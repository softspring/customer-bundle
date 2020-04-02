<?php

namespace Softspring\CustomerBundle\Controller;

use Psr\Log\LoggerInterface;
use Softspring\CoreBundle\Controller\AbstractController;
use Softspring\CustomerBundle\Platform\Adapter\NotifyAdapterInterface;
use Softspring\CustomerBundle\SfsCustomerEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class NotifyController extends AbstractController
{
    /**
     * @var NotifyAdapterInterface
     */
    protected $notifyAdapter;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * NotifyController constructor.
     *
     * @param NotifyAdapterInterface   $notifyAdapter
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface|null     $logger
     */
    public function __construct(NotifyAdapterInterface $notifyAdapter, EventDispatcherInterface $eventDispatcher, ?LoggerInterface $logger)
    {
        $this->notifyAdapter = $notifyAdapter;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function notify(Request $request): Response
    {
        try {
            $this->eventDispatcher->dispatch($this->notifyAdapter->createEvent($request), SfsCustomerEvents::NOTIFY);

            return new Response('', Response::HTTP_OK);
        } catch (\Exception $e) {
            $this->logger && $this->logger->info($request->server->get('HTTP_STRIPE_SIGNATURE'));
            $this->logger && $this->logger->error($e->getMessage());
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}