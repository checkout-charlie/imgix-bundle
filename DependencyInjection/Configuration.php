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
                ->variableNode('logger')
                    ->defaultNull()
                ->end()
                ->scalarNode('log_level')
                    ->defaultValue('notice')
                ->end()
                ->arrayNode('cdn_configurations')
                    ->normalizeKeys(false)
                    ->isRequired()
                    ->prototype('array')
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
                            ->arrayNode('default_query_params')
                                ->defaultValue([])
                                ->prototype('variable')->end()
                            ->end()
                            ->scalarNode('generate_filter_params')
                                ->defaultTrue()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('image_filters')
                    ->defaultValue([])
                    ->prototype('variable')
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
