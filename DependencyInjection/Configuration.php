<?php

namespace Softspring\CustomerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sfs_customer');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('entity_manager')
                    ->defaultValue('default')
                ->end()

                ->arrayNode('model')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('customer')->defaultValue('App\Entity\Customer')->end()
                        ->scalarNode('address')->defaultValue('App\Entity\CustomerAddress')->end()
                        ->scalarNode('source')->defaultValue('App\Entity\CustomerSource')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}