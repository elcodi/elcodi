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

namespace Elcodi\Bundle\CartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
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
                            'cart',
                            'Elcodi\Component\Cart\Entity\Cart',
                            '@ElcodiCartBundle/Resources/config/doctrine/Cart.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'order',
                            'Elcodi\Component\Cart\Entity\Order',
                            '@ElcodiCartBundle/Resources/config/doctrine/Order.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'cart_line',
                            'Elcodi\Component\Cart\Entity\CartLine',
                            '@ElcodiCartBundle/Resources/config/doctrine/CartLine.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'order_line',
                            'Elcodi\Component\Cart\Entity\OrderLine',
                            '@ElcodiCartBundle/Resources/config/doctrine/OrderLine.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'order_state_line',
                            'Elcodi\Component\Cart\Entity\OrderStateLine',
                            '@ElcodiCartBundle/Resources/config/doctrine/OrderStateLine.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('cart')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('save_in_session')
                            ->defaultTrue()
                        ->end()
                        ->scalarNode('session_field_name')
                            ->defaultValue('cart_id')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('order_state_transition_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('identifier')
                            ->defaultValue('order_state_transition_machine')
                        ->end()
                        ->scalarNode('point_of_entry')
                            ->defaultValue('new')
                        ->end()
                        ->variableNode('states')
                            ->defaultValue(array(
                                ['new', 'pay', 'paid'],
                                ['paid', 'ship', 'shipped'],
                            ))
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
