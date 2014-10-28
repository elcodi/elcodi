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

namespace Elcodi\Bundle\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;
use Elcodi\Component\Menu\Adapter\RouteGenerator\DummyRouteGeneratorAdapter;
use Elcodi\Component\Menu\Adapter\RouteGenerator\SymfonyRouteGeneratorAdapter;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->extensionName);

        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'menu',
                            'Elcodi\Component\Menu\Entity\Menu\Menu',
                            '@ElcodiMenuBundle/Resources/config/doctrine/Menu.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'menu_node',
                            'Elcodi\Component\Menu\Entity\Menu\Node',
                            '@ElcodiMenuBundle/Resources/config/doctrine/MenuNode.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('menus')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('cache_key')
                            ->defaultValue('menus')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('route_provider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('adapter')
                            ->values([
                                DummyRouteGeneratorAdapter::ADAPTER_NAME,
                                SymfonyRouteGeneratorAdapter::ADAPTER_NAME
                            ])
                            ->defaultValue(DummyRouteGeneratorAdapter::ADAPTER_NAME)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
