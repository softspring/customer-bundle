<?php

namespace Softspring\CustomerBundle\DependencyInjection;

use Softspring\CustomerBundle\Entity\CustomerAddress;
use Softspring\CustomerBundle\Model\AddressInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SfsCustomerExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('sfs_customer.entity_manager_name', $config['entity_manager']);
        $container->setParameter('sfs_customer.customer.class', $config['model']['customer']);
        $container->setParameter('sfs_customer.address.class', $config['model']['address']);
        $container->setParameter('sfs_customer.source.class', $config['model']['source']);

        // load services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));

        $loader->load('services.yaml');
        $loader->load('controller/admin_customers.yaml');
        $loader->load('controller/settings_sources.yaml');
    }


    public function prepend(ContainerBuilder $container)
    {
        $doctrineConfig = [];

        // add a default config to force load target_entities, will be overwritten by ResolveDoctrineTargetEntityPass
        $doctrineConfig['orm']['resolve_target_entities'][AddressInterface::class] = CustomerAddress::class;

        // disable auto-mapping for this bundle to prevent mapping errors
        $doctrineConfig['orm']['mappings']['SfsCustomerBundle'] = [
            'is_bundle' => true,
            'type' => 'annotation',
            'mapping' => 'annotations',
        ];

        $container->prependExtensionConfig('doctrine', $doctrineConfig);
    }
}