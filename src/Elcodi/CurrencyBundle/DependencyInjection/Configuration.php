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

namespace Elcodi\CurrencyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\CurrencyBundle\Adapter\DummyExchangeRatesAdapter;
use Elcodi\CurrencyBundle\Adapter\OpenExchangeRatesAdapter;

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
        $rootNode = $treeBuilder->root('elcodi_currency');

        $rootNode
            ->children()
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
                        ->enumNode('client')
                            ->values([
                                DummyExchangeRatesAdapter::ADAPTER_NAME,
                                OpenExchangeRatesAdapter::ADAPTER_NAME
                            ])
                            ->defaultValue(DummyExchangeRatesAdapter::ADAPTER_NAME)
                        ->end()
                    ->end()
                    ->append($this->addOpenExchangeRatesParametersNode())
                ->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * Require Open exchange configuration
     */
    public function addOpenExchangeRatesParametersNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root(OpenExchangeRatesAdapter::ADAPTER_NAME);

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
