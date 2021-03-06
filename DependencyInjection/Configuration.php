<?php

namespace Tacticmedia\ImgixBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tacticmedia_imgix');

        $rootNode
            ->children()
                ->scalarNode('default_source')
                    ->defaultValue('default')
                    ->end()
                ->booleanNode('enabled')
                    ->defaultFalse()
                    ->end()
                ->append($this->getSourcesNode())
            ->end()
        ;

        return $treeBuilder;
    }

    private function getSourcesNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('sources');

        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('domain')
                        ->isRequired()
                        ->end()
                    ->scalarNode('sign_key')
                        ->defaultValue('')
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
