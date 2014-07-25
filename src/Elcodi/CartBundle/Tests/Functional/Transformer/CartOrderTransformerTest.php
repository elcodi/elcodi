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

namespace Elcodi\CartBundle\Tests\Functional\Transformer;

use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Transformer\CartOrderTransformer;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CoreBundle\Tests\Functional\WebTestCase;

/**
 * Class CartOrderTransformerTest
 */
class CartOrderTransformerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart.transformer.cart_order',
            'elcodi.cart_order_transformer',
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiProductBundle',
            'ElcodiAttributeBundle',
            'ElcodiCurrencyBundle',
            'ElcodiUserBundle',
            'ElcodiCartBundle',
        ];
    }

    /**
     * test createFromCart method
     *
     * @group order
     */
    public function testCreateOrderFromCart()
    {
        /**
         * @var CartOrderTransformer $cartOrderTransformer
         */
        $cartOrderTransformer = $this
            ->container
            ->get('elcodi.cart_order_transformer');

        $orderInitialState = $this
            ->container
            ->getParameter('elcodi.core.cart.order_initial_state');

        /**
         * @var CartInterface $cart
         */
        $cart = $this
            ->getRepository('elcodi.core.cart.entity.cart.class')
            ->find(2);

        $this
            ->container
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartLoadEvents($cart);

        $order = $cartOrderTransformer->createOrderFromCart($cart);

        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderInterface', $order);
        $this->assertSame($order->getCart(), $cart);
        $this->assertTrue($cart->isOrdered());
        $this->assertCount(2, $order->getOrderLines());
        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface', $order->getLastOrderHistory());
        $this->assertEquals($order->getLastOrderHistory()->getState(), $orderInitialState);

        $orderHistories = $order->getOrderHistories();

        /**
         * @var OrderHistoryInterface $orderHistory
         */
        foreach ($orderHistories as $orderHistory) {

            $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface', $orderHistory);
            $this->assertEquals($orderHistory->getState(), $orderInitialState);
        }

        $this
            ->getManager('elcodi.core.cart.entity.order.class')
            ->clear();

        $this->assertCount(1, $this
            ->getRepository('elcodi.core.cart.entity.order.class')
            ->findAll()
        );
    }

}
