<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * Class Configuration
 */
class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritDoc}
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
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

                        ->arrayNode('domain_sharding')
                            ->canBeEnabled()
                            ->children()
                                ->arrayNode('base_urls')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('view')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('controller_route_name')
                                    ->defaultValue('_elcodi_media_image_view')
                                ->end()
                                ->scalarNode('controller_route')
                                    ->defaultValue('/images/{id}/render.{_format}')
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
                                    ->defaultValue('file')
                                ->end()
                                ->scalarNode('controller_route_name')
                                    ->defaultValue('elcodi_media_image_upload')
                                ->end()
                                ->scalarNode('controller_route')
                                    ->defaultValue('/images/upload')
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
                                    ->defaultValue('_elcodi_media_image_resize')
                                ->end()
                                ->scalarNode('controller_route')
                                    ->defaultValue('/images/{id}/resize/{height}/{width}/{type}.{_format}')
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
    }
}
