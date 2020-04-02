<?php

namespace Softspring\CustomerBundle\DependencyInjection\Compiler;

use Softspring\CustomerBundle\Platform\ApiManagerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ApiAdaptersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has(ApiManagerInterface::class)) {
            return;
        }

        $definition = $container->findDefinition(ApiManagerInterface::class);

        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds('sfs_customer.platform.adapter');

        $adapters = [];

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $adapters[$attributes['alias']] = new Reference($id);
            }
        }

        $definition->setArgument('$adapters', $adapters);
    }
}