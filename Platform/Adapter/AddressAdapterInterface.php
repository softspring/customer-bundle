<?php

namespace Softspring\CustomerBundle\Platform\Adapter;

use Softspring\CustomerBundle\Model\AddressInterface;
use Softspring\CustomerBundle\Platform\Exception\PlatformException;

interface AddressAdapterInterface extends PlatformAdapterInterface
{
    /**
     * Creates address on defined platform
     *
     * @param AddressInterface $address
     *
     * @return mixed
     * @throws PlatformException
     */
    public function create(AddressInterface $address);

    /**
     * Retrive the address platform data
     *
     * @param AddressInterface $address
     *
     * @return mixed
     * @throws PlatformException
     */
    public function get(AddressInterface $address);
}