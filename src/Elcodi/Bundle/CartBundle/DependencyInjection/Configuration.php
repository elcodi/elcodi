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

namespace Elcodi\Bundle\CartBundle\DependencyInjection;

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
                ->arrayNode('payment_states_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('identifier')
                            ->defaultValue('order_payment_states_machine')
                        ->end()
                        ->scalarNode('point_of_entry')
                            ->defaultValue('unpaid')
                        ->end()
                        ->variableNode('states')
                            ->defaultValue([
                                ['unpaid', 'pay', 'paid'],
                                ['paid', 'refund', 'refunded'],
                            ])
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('shipping_states_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('identifier')
                            ->defaultValue('order_shipping_states_machine')
                        ->end()
                        ->scalarNode('point_of_entry')
                            ->defaultValue('preparing')
                        ->end()
                        ->variableNode('states')
                            ->defaultValue([
                                ['preparing', 'order ready', 'processed'],
                                ['processed', 'picked up by carrier', 'in delivery'],
                                ['processed', 'picked up on store', 'delivered'],
                                ['in delivery', 'delivered', 'delivered'],
                                ['preparing', 'cancel', 'cancelled'],
                                ['processed', 'cancel', 'cancelled'],
                                ['in delivery', 'cancel', 'cancelled'],
                                ['in delivery', 'return', 'returned'],
                                ['delivered', 'return', 'returned'],
                            ])
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
