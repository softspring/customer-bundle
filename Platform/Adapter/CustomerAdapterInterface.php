<?php

namespace Softspring\CustomerBundle\Platform\Adapter;

use Softspring\CustomerBundle\Model\CustomerInterface;

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
     */
    public function create(CustomerInterface $customer);

    /**
     * Updates customer on defined platform
     *
     * @param CustomerInterface $customer
     *
     * @return mixed
     */
    public function update(CustomerInterface $customer);

    /**
     * Deletes customer on defined platform
     *
     * @param CustomerInterface $customer
     *
     * @return mixed
     */
    public function delete(CustomerInterface $customer);

    /**
     * Retrive the customer platform data
     *
     * @param CustomerInterface $customer
     *
     * @return mixed
     */
    public function get(CustomerInterface $customer);

//    /**
//     * @param CustomerInterface $customer
//     * @param string            $token
//     *
//     * @return object|array
//     */
//    public function addCard(CustomerInterface $customer, string $token);
//
//    /**
//     * @param CustomerInterface $customer
//     *
//     * @return array
//     */
//    public function invoices(CustomerInterface $customer): array;
}