<?php

namespace Softspring\CustomerBundle\Adapter\Stripe;

use Psr\Log\LoggerInterface;
use Softspring\CustomerBundle\Exception\NotFoundInPlatform;
use Softspring\CustomerBundle\Exception\PaymentException;
use Softspring\CustomerBundle\Exception\PlatformException;
use Softspring\CustomerBundle\PlatformInterface;
use Softspring\SubscriptionBundle\Exception\MaxSubscriptionsReachException;
use Softspring\SubscriptionBundle\Exception\SubscriptionException;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Stripe;

abstract class AbstractStripeAdapter
{
    /**
     * @var string
     */
    protected $apiSecretKey;

    /**
     * @var string|null
     */
    protected $webhookSigningSecret;

    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * AbstractStripeAdapter constructor.
     *
     * @param string               $apiSecretKey
     * @param string|null          $webhookSigningSecret
     * @param LoggerInterface|null $logger
     */
    public function __construct(string $apiSecretKey, ?string $webhookSigningSecret, ?LoggerInterface $logger)
    {
        $this->apiSecretKey = $apiSecretKey;
        $this->webhookSigningSecret = $webhookSigningSecret;
        $this->logger = $logger;
    }

    /**
     * Initialize stripe client object
     */
    protected function initStripe()
    {
        Stripe::setApiKey($this->apiSecretKey);
    }

    /**
     * @param \Throwable $e
     *
     * @throws PlatformException
     */
    protected function attachStripeExceptions(\Throwable $e): void
    {
        if ($e instanceof ApiConnectionException) {
            $this->logger->error(sprintf('Can not connect to Stripe: %s', $e->getMessage()));
            throw new PlatformException(PlatformInterface::PLATFORM_STRIPE, 'api_connection_error', 'Can not connecto to stripe', 0, $e);
        }

        if ($e instanceof CardException) {
            switch ($e->getStripeCode()) {
                case 'card_declined':
                    throw new PaymentException(PlatformInterface::PLATFORM_STRIPE, $e->getDeclineCode(), $e->getMessage(), 0, $e);
                    break;
            }

            $this->logger->error(sprintf('Stripe unknown card error: %s', $e->getMessage()));
            throw new PaymentException(PlatformInterface::PLATFORM_STRIPE, 'unknown_card_error', 'Stripe unknown card error', 0, $e);
        }

        if ($e instanceof InvalidRequestException) {
            switch ($e->getStripeCode()) {
                case 'customer_max_subscriptions':
                    $this->logger->warning(sprintf('Stripe customer has reached max subscriptions limit'));
                    throw new MaxSubscriptionsReachException(PlatformInterface::PLATFORM_STRIPE, 'customer_max_subscriptions', $e->getMessage(), 0, $e);

                case 'resource_missing':
                    $this->logger->error(sprintf('Stripe resource %s not found', $e->getRequestId()));
                    throw new NotFoundInPlatform(PlatformInterface::PLATFORM_STRIPE, 'not_found',$e->getMessage(), 0, $e);

                default:
                    $this->logger->error(sprintf('Stripe invalid request: %s', $e->getMessage()));
                    throw new SubscriptionException(PlatformInterface::PLATFORM_STRIPE, 'invalid_request','Invalid stripe request', 0, $e);
            }
        }

        $this->logger->error(sprintf('Stripe unknown exception: %s', $e->getMessage()));
        throw new SubscriptionException(PlatformInterface::PLATFORM_STRIPE, 'unknown_error', 'Unknown stripe exception', 0, $e);
    }
}