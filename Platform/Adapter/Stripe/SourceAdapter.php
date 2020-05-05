<?php

namespace Softspring\CustomerBundle\Platform\Adapter\Stripe;

use Psr\Log\LoggerInterface;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Model\SourceInterface;
use Softspring\CustomerBundle\Platform\Adapter\CustomerAdapterInterface;
use Softspring\CustomerBundle\Platform\Adapter\SourceAdapterInterface;
use Softspring\CustomerBundle\Platform\Exception\CustomerException;
use Softspring\CustomerBundle\Platform\PlatformInterface;
use Stripe\Customer;
use Stripe\Exception\InvalidRequestException;
use Stripe\Source;

class SourceAdapter extends AbstractStripeAdapter implements SourceAdapterInterface
{
    /**
     * @var CustomerAdapterInterface
     */
    protected $customerAdapter;

    /**
     * SourceAdapter constructor.
     *
     * @param CustomerAdapterInterface $customerAdapter
     * @param string                   $apiSecretKey
     * @param string|null              $webhookSigningSecret
     * @param LoggerInterface|null     $logger
     */
    public function __construct(CustomerAdapterInterface $customerAdapter, string $apiSecretKey, ?string $webhookSigningSecret, ?LoggerInterface $logger)
    {
        parent::__construct($apiSecretKey, $webhookSigningSecret, $logger);
        $this->customerAdapter = $customerAdapter;
    }

    public function syncSource(SourceInterface $source, Source $sourceStripe)
    {
        // save platform data
        $source->setPlatform(PlatformInterface::PLATFORM_STRIPE);
        $source->setPlatformId($sourceStripe->id);
        $source->setTestMode(!$sourceStripe->livemode);
        // $source->setPlatformLastSync($sourceStripe->created);
        $source->setPlatformConflict(false);
        $source->setPlatformData($sourceStripe->toArray());
    }

    /**
     * @inheritDoc
     */
    public function create(SourceInterface $source)
    {
        try {
            if ( ! ($customer = $source->getCustomer()) instanceof CustomerInterface) {
                throw new \Exception('Missing customer in source object');
            }

            $this->initStripe();

            /** @var Customer $customerStripe */
            $customerStripe = $this->customerAdapter->get($customer);

            /** @var Source $sourceStripe */
            $sourceStripe = $customerStripe->sources->create(['source' => $source->getPlatformToken()]);

            // save default
            if ($customer->getDefaultSource() === $source) {
                if ($customerStripe->default_source !== $sourceStripe->id) {
                    // set default
                    $customerStripe->default_source = $sourceStripe;
                }
            }

            $customerStripe->save();

            $this->syncSource($source, $sourceStripe);

            return $sourceStripe;
        } catch (\Exception $e) {
            return $this->attachStripeExceptions($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(SourceInterface $source)
    {
        try {
            $this->initStripe();

            $sourceStripe = $this->stripeClientRetrieve($source->getCustomer()->getPlatformId(), $source->getPlatformId());

            $this->syncSource($source, $sourceStripe);

            return $sourceStripe;
        } catch (\Exception $e) {
            return $this->attachStripeExceptions($e);
        }
    }

    protected function stripeClientRetrieve($id, $sourceId, $params = null, $opts = null): Source
    {
        return Customer::retrieveSource($id, $sourceId, $params, $opts);
    }
}