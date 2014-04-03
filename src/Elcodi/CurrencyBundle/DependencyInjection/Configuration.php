<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CurrencyBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('elcodi_currency');

        $rootNode
            ->children()
                ->scalarNode('default_currency')
                    ->defaultValue('USD')
                ->end()
                ->scalarNode('provider')
                    ->defaultValue('Elcodi\Bundles\\Core\\CurrencyBundle\\Provider\\OpenExchangeRatesProvider')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
