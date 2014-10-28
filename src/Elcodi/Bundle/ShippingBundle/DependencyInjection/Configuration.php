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

namespace Elcodi\Bundle\ShippingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;
use Elcodi\Component\Shipping\ElcodiShippingResolverTypes;

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
                            'carrier',
                            'Elcodi\Component\Shipping\Entity\Carrier',
                            '@ElcodiShippingBundle/Resources/config/doctrine/Carrier.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'carrier_base_range',
                            'Elcodi\Component\Shipping\Entity\Abstracts\AbstractCarrierBaseRange',
                            '@ElcodiShippingBundle/Resources/config/doctrine/CarrierBaseRange.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'carrier_price_range',
                            'Elcodi\Component\Shipping\Entity\CarrierPriceRange',
                            '@ElcodiShippingBundle/Resources/config/doctrine/CarrierPriceRange.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'carrier_weight_range',
                            'Elcodi\Component\Shipping\Entity\CarrierWeightRange',
                            '@ElcodiShippingBundle/Resources/config/doctrine/CarrierWeightRange.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'warehouse',
                            'Elcodi\Component\Shipping\Entity\Warehouse',
                            '@ElcodiShippingBundle/Resources/config/doctrine/Warehouse.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('carrier')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('resolve_strategy')
                            ->values([
                                ElcodiShippingResolverTypes::CARRIER_RESOLVER_ALL,
                                ElcodiShippingResolverTypes::CARRIER_RESOLVER_HIGHEST,
                                ElcodiShippingResolverTypes::CARRIER_RESOLVER_LOWEST,
                            ])
                            ->defaultValue(ElcodiShippingResolverTypes::CARRIER_RESOLVER_ALL)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
