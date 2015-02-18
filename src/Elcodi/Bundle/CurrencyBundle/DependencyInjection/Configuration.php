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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\CurrencyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

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
                            'currency',
                            'Elcodi\Component\Currency\Entity\Currency',
                            '@ElcodiCurrencyBundle/Resources/config/doctrine/Currency.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'currency_exchange_rate',
                            'Elcodi\Component\Currency\Entity\CurrencyExchangeRate',
                            '@ElcodiCurrencyBundle/Resources/config/doctrine/CurrencyExchangeRate.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('currency')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default_currency')
                            ->defaultValue('USD')
                        ->end()
                        ->scalarNode('session_field_name')
                            ->defaultValue('currency_id')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('rates_provider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('currency_base')
                            ->defaultValue('USD')
                        ->end()
                        ->scalarNode('client')
                            ->defaultValue('elcodi.adapter.currency_exchange_rate.dummy')
                        ->end()
                    ->end()
                    ->append($this->addOpenExchangeRatesParametersNode())
                ->end()
            ->end();
    }

    /**
     * Require Open exchange configuration
     */
    public function addOpenExchangeRatesParametersNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('open_exchange_rates');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('api_id')
                    ->defaultValue('00000')
                ->end()
                ->scalarNode('endpoint')
                    ->defaultValue('http://openexchangerates.org/api')
                ->end()
            ->end();

        return $node;
    }
}
