<?php

namespace Softspring\CustomerBundle;

class SfsCustomerEvents
{
    /**
     * @Event("Softspring\CoreBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_LIST_VIEW = 'sfs_customer.admin.customers.list_view';

    /**
     * @Event("Softspring\CoreBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_DETAILS_VIEW = 'sfs_customer.admin.customers.details_view';

    /**
     * @Event("Softspring\CrudlBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_INITIALIZE = 'sfs_customer.admin.customers.create_initialize';

    /**
     * @Event("Softspring\CrudlBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_FORM_VALID = 'sfs_customer.admin.customers.create_form_valid';

    /**
     * @Event("Softspring\CrudlBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_SUCCESS = 'sfs_customer.admin.customers.create_success';

    /**
     * @Event("Softspring\CrudlBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_FORM_INVALID = 'sfs_customer.admin.customers.create_form_invalid';

    /**
     * @Event("Softspring\CoreBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_VIEW = 'sfs_customer.admin.customers.create_view';

    /**
     * @Event("Softspring\CoreBundle\Event\ViewEvent")
     */
    const SETTINGS_SOURCES_LIST_VIEW = 'sfs_customer.settings.sources.list_view';
}