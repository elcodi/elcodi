<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elcodi_media');

        $rootNode
            ->children()
                ->arrayNode('images')
                    ->addDefaultsIfNotSet()
                    ->children()

                        ->scalarNode('filesystem')
                            ->isRequired()
                        ->end()

                        ->arrayNode('upload')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('field_name')
                                    ->defaultValue('image')
                                ->end()
                                ->scalarNode('controller_route_name')
                                    ->defaultValue('elcodi_media_image_upload')
                                ->end()
                                ->scalarNode('controller_route')
                                    ->defaultValue('/image/upload')
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('resize')
                            ->addDefaultsIfNotSet()
                            ->children()

                                /**
                                 * This elements should be defined as an enumValue
                                 *
                                 * While only one element is defined,
                                 * defined as scalarNode
                                 */
                                ->scalarNode('engine')
                                    ->defaultValue('imagemagick')
                                ->end()
                                ->scalarNode('controller_route_name')
                                    ->defaultValue('elcodi_media_image_resize')
                                ->end()
                                ->scalarNode('controller_route')
                                    ->defaultValue('/image/{id}/resize/{height}/{width}/{type}')
                                ->end()

                                ->scalarNode('converter_bin_path')
                                    ->defaultValue('/usr/bin/convert')
                                ->end()
                                ->scalarNode('converter_default_profile')
                                    ->defaultValue('/usr/share/color/icc/colord/sRGB.icc')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
