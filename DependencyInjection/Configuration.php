<?php

namespace Sparwelt\ImgixBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sparwelt_imgix');

        $rootNode
            ->children()
                ->arrayNode('cdn_configurations')
                    ->normalizeKeys(false)
                    ->isRequired()
                    ->arrayPrototype()
                    ->isRequired()
                        ->children()
                            ->arrayNode('cdn_domains')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('source_domains')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('path_patterns')
                                ->prototype('scalar')->end()
                            ->end()
                            ->scalarNode('sign_key')
                                ->defaultNull()
                            ->end()
                            ->scalarNode('shard_strategy')
                                ->defaultValue('crc')
                            ->end()
                            ->scalarNode('use_ssl')
                                ->defaultTrue()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('image_filters')
                    ->defaultValue([])
                    ->variablePrototype()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
