<?php

namespace Softspring\CustomerBundle;

class SfsCustomerEvents
{
    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_LIST_VIEW = 'sfs_customer.admin.customers.read_view';
}