<?php

namespace Softspring\CustomerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SfsCustomerExtension extends Extension
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

        // load services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));

        $container->setParameter('sfs_customer.adapter.name', $config['adapter']['driver']);

        if ($config['adapter']['driver'] == 'stripe') {
            $container->setParameter('sfs_customer.adapter.stripe.apiSecretKey', $config['adapter']['options']['apiSecretKey']);
            $container->setParameter('sfs_customer.adapter.stripe.webhookSigningSecret', $config['adapter']['options']['webhookSigningSecret'] ?? null);
            $loader->load('adapter/stripe.yaml');
        }

        $loader->load('services.yaml');
        $loader->load('controller/admin_customers.yaml');
    }

}