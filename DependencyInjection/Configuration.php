<?php

namespace Astina\Bundle\SolvencyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('astina_solvency');

        $rootNode
            ->children()
                ->arrayNode('provider')
                    ->children()
                        ->arrayNode('deltavista')
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('wsdl_url')->isRequired()->end()
                                ->scalarNode('user')->isRequired()->end()
                                ->scalarNode('password')->isRequired()->end()
                                ->scalarNode('correlation_id')->end()
                                ->scalarNode('endpoint_url')->defaultNull()->end()
                            ->end()
                        ->end()
                        ->arrayNode('intrum')
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('user_id')->isRequired()->end()
                                ->scalarNode('client_id')->isRequired()->end()
                                ->scalarNode('client_email')->isRequired()->end()
                                ->scalarNode('password')->isRequired()->end()
                                ->scalarNode('endpoint_url')->end()
                            ->end()
                        ->end()
                        ->arrayNode('mock')
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('status')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('cache')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('cache_dir')->end()
                        ->scalarNode('lifetime')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;       

        return $treeBuilder;
    }
}
