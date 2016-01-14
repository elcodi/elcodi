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

namespace Elcodi\Bundle\CurrencyBundle\DependencyInjection;

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
                        ->scalarNode('adapter')
                            ->defaultValue('elcodi.currency_exchange_rate_adapter.yahoo_finances')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
