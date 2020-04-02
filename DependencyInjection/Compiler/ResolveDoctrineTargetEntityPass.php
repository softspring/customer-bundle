<?php

namespace Softspring\CustomerBundle\DependencyInjection\Compiler;

use Softspring\CoreBundle\DependencyInjection\Compiler\AbstractResolveDoctrineTargetEntityPass;
use Softspring\CustomerBundle\Model\AddressInterface;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Model\SourceInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ResolveDoctrineTargetEntityPass extends AbstractResolveDoctrineTargetEntityPass
{
    /**
     * @inheritDoc
     */
    protected function getEntityManagerName(ContainerBuilder $container): string
    {
        return $container->getParameter('sfs_customer.entity_manager_name');
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->setTargetEntityFromParameter('sfs_customer.customer.class', CustomerInterface::class, $container, true);
        $this->setTargetEntityFromParameter('sfs_customer.address.class', AddressInterface::class, $container, true);
        $this->setTargetEntityFromParameter('sfs_customer.source.class', SourceInterface::class, $container, true);
    }
}