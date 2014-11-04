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

namespace Elcodi\Bundle\ProductBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

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
                            'product',
                            'Elcodi\Component\Product\Entity\Product',
                            '@ElcodiProductBundle/Resources/config/doctrine/Product.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'variant',
                            'Elcodi\Component\Product\Entity\Variant',
                            '@ElcodiProductBundle/Resources/config/doctrine/Variant.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'category',
                            'Elcodi\Component\Product\Entity\Category',
                            '@ElcodiProductBundle/Resources/config/doctrine/Category.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'manufacturer',
                            'Elcodi\Component\Product\Entity\Manufacturer',
                            '@ElcodiProductBundle/Resources/config/doctrine/Manufacturer.orm.yml',
                            'default',
                            true
                        ))
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
