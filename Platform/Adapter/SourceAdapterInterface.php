<?php

namespace Softspring\CustomerBundle\Platform\Adapter;

use Softspring\CustomerBundle\Model\SourceInterface;
use Softspring\CustomerBundle\Platform\Exception\PlatformException;

interface SourceAdapterInterface extends PlatformAdapterInterface
{
    /**
     * Creates source on defined platform
     *
     * @param SourceInterface $source
     *
     * @return mixed
     * @throws PlatformException
     */
    public function create(SourceInterface $source);

    /**
     * Retrive the source platform data
     *
     * @param SourceInterface $source
     *
     * @return mixed
     * @throws PlatformException
     */
    public function get(SourceInterface $source);
}