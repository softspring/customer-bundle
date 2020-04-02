<?php

namespace Softspring\CustomerBundle\Platform\Adapter\Stripe;

use Softspring\CustomerBundle\Event\NotifyEvent;
use Softspring\CustomerBundle\Platform\Adapter\NotifyAdapterInterface;
use Softspring\CustomerBundle\Platform\PlatformInterface;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Request;

class NotifyAdapter extends AbstractStripeAdapter implements NotifyAdapterInterface
{
    /**
     * @param Request $request
     *
     * @return NotifyEvent
     * @throws SignatureVerificationException
     * @throws \Softspring\CustomerBundle\Platform\Exception\PlatformException
     */
    public function createEvent(Request $request): NotifyEvent
    {
        $this->initStripe();

        try {
            if (null === ($payload = json_decode($request->getContent(), true))) {
                throw new \UnexpectedValueException('Bad JSON body from Stripe!');
            }
            $sig_header = $request->server->get('HTTP_STRIPE_SIGNATURE');
            $event = Webhook::constructEvent($request->getContent(), $sig_header, $this->webhookSigningSecret);
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            throw $e;
        } catch(SignatureVerificationException $e) {
            // Invalid signature
            throw $e;
        } catch (\Exception $e) {
            $this->attachStripeExceptions($e);
        }

        $this->logger && $this->logger->info(sprintf('Stripe webhook received: %s, event: %s', $event->id, $event->type));
        return new NotifyEvent(PlatformInterface::PLATFORM_STRIPE, $event->type, $event);
    }

}