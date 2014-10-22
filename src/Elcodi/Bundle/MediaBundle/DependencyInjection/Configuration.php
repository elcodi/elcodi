<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Bundle\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * Class Configuration
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(ElcodiMediaExtension::getExtensionName());

        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'image',
                            'Elcodi\Component\Media\Entity\Image',
                            '@ElcodiMediaBundle/Resources/config/doctrine/Image.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->scalarNode('filesystem')
                    ->defaultValue('gaufrette.local_filesystem')
                ->end()
                ->arrayNode('images')
                    ->addDefaultsIfNotSet()
                    ->children()

                        ->arrayNode('view')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('controller_route_name')
                                    ->defaultValue('elcodi_media_image_view')
                                ->end()
                                ->scalarNode('controller_route')
                                    ->defaultValue('/image/{id}/render')
                                ->end()
                                ->integerNode('max_age')
                                    ->defaultValue(7884000)
                                ->end()
                                ->integerNode('shared_max_age')
                                    ->defaultValue(7884000)
                                ->end()
                            ->end()
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
