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

namespace Elcodi\Bundle\ProductBundle\DependencyInjection;

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
                            'product',
                            'Elcodi\Component\Product\Entity\Product',
                            '@ElcodiProductBundle/Resources/config/doctrine/Product.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'product_variant',
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
                ->arrayNode('products')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('use_stock')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('categories')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('load_only_categories_with_products')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('cache_key')
                            ->defaultValue('categories')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
