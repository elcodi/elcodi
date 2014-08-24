<?php

/**
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

namespace Elcodi\Bundle\ProductBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(ElcodiProductExtension::getExtensionName());

        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('product')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('Elcodi\Component\Product\Entity\Product')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('mapping_file')
                                    ->defaultValue('@ElcodiProductBundle/Resources/config/doctrine/Product.orm.yml')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('manager')
                                    ->defaultValue('default')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('variant')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('Elcodi\Component\Product\Entity\Variant')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('mapping_file')
                                    ->defaultValue('@ElcodiProductBundle/Resources/config/doctrine/Variant.orm.yml')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('manager')
                                    ->defaultValue('default')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('category')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('Elcodi\Component\Product\Entity\Category')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('mapping_file')
                                    ->defaultValue('@ElcodiProductBundle/Resources/config/doctrine/Category.orm.yml')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('manager')
                                    ->defaultValue('default')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('manufacturer')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('Elcodi\Component\Product\Entity\Manufacturer')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('mapping_file')
                                    ->defaultValue('@ElcodiProductBundle/Resources/config/doctrine/Manufacturer.orm.yml')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('manager')
                                    ->defaultValue('default')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('categories')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('load_only_categories_with_products')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('cache_key')
                            ->defaultValue('categories')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
