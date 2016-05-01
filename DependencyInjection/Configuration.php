<?php

namespace ResponsiveImageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('responsive_image');

        // Add basic configurations.
        $rootNode
            ->children()
                ->booleanNode('debug')
                    ->defaultFalse()
                ->end()
                ->variableNode('image_entity_class')
                    ->defaultValue([])
                ->end()
                ->scalarNode('image_driver')
                    ->defaultValue('gd')
                    ->validate()
                        ->ifNotInArray(array('gd', 'imagemagik'))
                        ->thenInvalid('In valid PHP image library')
                    ->end()
                ->end()
                ->integerNode('image_compression')
                    ->defaultValue(90)
                    ->min(0)->max(100)
                ->end()
                ->scalarNode('image_directory')
                    ->defaultValue('images')
                ->end()
                ->scalarNode('image_styles_directory')
                    ->defaultValue('styles')
                ->end()
                ->arrayNode('breakpoints')
                    ->prototype('scalar')->end()
                ->end()
                ->variableNode('image_styles')->end()
                ->variableNode('picture_sets')->end()
                ->variableNode('crop_focus_widget')->end()
                ->append($this->addAWSNode())
            ->end()
        ;

        return $treeBuilder;
    }

    protected function addAWSNode() {
        $builder = new TreeBuilder();
        $node = $builder->root('aws_s3');

        $node
            ->children()
                ->booleanNode('enabled')
                    ->defaultFalse()
                ->end()
                ->enumNode('keep_local_files')
                    ->defaultValue('NONE')
                    ->values(['NONE', 'ALL', 'ORIGINAL_ONLY'])
                ->end()
                ->enumNode('move_to_bucket')
                    ->defaultValue('ALL')
                    ->values(['ALL', 'STYLED_ONLY'])
                ->end()
                ->scalarNode('temp_directory')
                    ->defaultValue(null)
                ->end()
                ->scalarNode('bucket')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('region')
                    ->defaultValue('eu-west-1')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('version')
                    ->defaultValue('latest')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('directory')
                    ->defaultValue('')
                ->end()
                ->enumNode('protocol')
                    ->defaultValue('http')
                    ->values(['http', 'https'])
                ->end()
                ->scalarNode('access_key_id')->end()
                ->scalarNode('secret_access_key')->end()
            ->end()
        ;

        return $node;
    }
}