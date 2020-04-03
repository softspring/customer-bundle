<?php

namespace Softspring\CustomerBundle\Platform\Adapter;

use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Platform\Exception\PlatformException;

/**
 * Interface CustomerAdapterInterface
 */
interface CustomerAdapterInterface extends PlatformAdapterInterface
{
    /**
     * Creates customer on defined platform
     *
     * @param CustomerInterface $customer
     *
     * @return mixed
     * @throws PlatformException
     */
    public function create(CustomerInterface $customer);

    /**
     * Updates customer on defined platform
     *
     * @param CustomerInterface $customer
     *
     * @return mixed
     * @throws PlatformException
     */
    public function update(CustomerInterface $customer);

    /**
     * Deletes customer on defined platform
     *
     * @param CustomerInterface $customer
     *
     * @return mixed
     * @throws PlatformException
     */
    public function delete(CustomerInterface $customer);

    /**
     * Retrive the customer platform data
     *
     * @param CustomerInterface $customer
     *
     * @return mixed
     * @throws PlatformException
     */
    public function get(CustomerInterface $customer);
}