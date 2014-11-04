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

namespace Elcodi\Bundle\CurrencyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;
use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\DummyProviderAdapter as DummyCurrencyExchangeRatesProviderAdapter;
use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\OpenExchangeRatesProviderAdapter;
use Elcodi\Component\Currency\Adapter\LocaleProvider\DummyProviderAdapter as DummyLocaleProviderAdapter;
use Elcodi\Component\Currency\Adapter\LocaleProvider\ElcodiProviderAdapter;

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
                        ->enumNode('client')
                            ->values([
                                DummyCurrencyExchangeRatesProviderAdapter::ADAPTER_NAME,
                                OpenExchangeRatesProviderAdapter::ADAPTER_NAME
                            ])
                            ->defaultValue(DummyCurrencyExchangeRatesProviderAdapter::ADAPTER_NAME)
                        ->end()
                    ->end()
                    ->append($this->addOpenExchangeRatesParametersNode())
                ->end()
                ->arrayNode('locale_provider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('adapter')
                            ->values([
                                DummyLocaleProviderAdapter::ADAPTER_NAME,
                                ElcodiProviderAdapter::ADAPTER_NAME
                            ])
                            ->defaultValue(DummyLocaleProviderAdapter::ADAPTER_NAME)
                        ->end()
                    ->end()
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
        $node = $treeBuilder->root(OpenExchangeRatesProviderAdapter::ADAPTER_NAME);

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
