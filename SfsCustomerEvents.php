<?php

namespace Softspring\CustomerBundle;

class SfsCustomerEvents
{
    /**
     * @Event("Softspring\CustomerBundle\Event\NotifyEvent")
     */
    const NOTIFY = 'sfs_subscription.notify';

    /**
     * @Event("Softspring\CoreBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_LIST_VIEW = 'sfs_customer.admin.customers.list_view';

    /**
     * @Event("Softspring\CoreBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_DETAILS_VIEW = 'sfs_customer.admin.customers.details_view';
}