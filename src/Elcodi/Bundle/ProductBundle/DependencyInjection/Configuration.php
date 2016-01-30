<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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
 * Class Configuration.
 */
class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritdoc}
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'purchasable',
                            'Elcodi\Component\Product\Entity\Purchasable',
                            '@ElcodiProductBundle/Resources/config/doctrine/Purchasable.orm.yml',
                            'default',
                            true
                        ))
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
                            'purchasable_pack',
                            'Elcodi\Component\Product\Entity\Pack',
                            '@ElcodiProductBundle/Resources/config/doctrine/Pack.orm.yml',
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
                        ->arrayNode('related_products_adapter')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('adapter')
                                    ->defaultValue('elcodi.related_products_provider_adapter.same_category')
                                ->end()
                            ->end()
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
                ->arrayNode('related_purchasables_provider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('adapter')
                            ->defaultValue('elcodi.related_purchasables_provider.same_category')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
