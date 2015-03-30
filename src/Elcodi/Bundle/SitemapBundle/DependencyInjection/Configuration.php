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

namespace Elcodi\Bundle\SitemapBundle\DependencyInjection;

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
                ->arrayNode('blocks')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('transformer')
                                ->isRequired()
                            ->end()
                            ->scalarNode('repository_service')
                                ->isRequired()
                            ->end()
                            ->scalarNode('method')
                                ->defaultValue('findBy')
                            ->end()
                            ->arrayNode('arguments')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')

                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('profiles')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('path')
                                ->isRequired()
                                ->beforeNormalization()
                                    ->always()
                                    ->then(function ($path) {
                                        return realpath($path);
                                    })
                                ->end()
                            ->end()
                            ->scalarNode('render')
                                ->defaultValue('elcodi.core.sitemap.render.xml')
                            ->end()
                            ->arrayNode('blocks')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')

                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
