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

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Transformer\CartOrderTransformer;
use Elcodi\CoreBundle\Tests\Functional\WebTestCase;

/**
 * Class CartOrderTransformerTest
 */
class CartOrderTransformerTest extends WebTestCase
{
    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

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
            'ElcodiCartBundle',
        ];
    }

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var CartOrderTransformer $cartOrderTransformer
         */
        $cartOrderTransformer = $this
            ->get('elcodi.cart_order_transformer');

        /**
         * @var CartInterface $cart
         */
        $this->cart = $this->find('cart', 2);

        $this
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartLoadEvents($this->cart);

        $this->order = $cartOrderTransformer->createOrderFromCart($this->cart);
    }

    /**
     * test createFromCart method
     *
     * @group order
     */
    public function testCreateOrderFromCart()
    {
        $orderInitialState = $this
            ->getParameter('elcodi.core.cart.order_initial_state');

        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderInterface', $this->order);
        $this->assertSame($this->order->getCart(), $this->cart);
        $this->assertTrue($this->cart->isOrdered());
        $this->assertCount(2, $this->order->getOrderLines());
        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface', $this->order->getLastOrderHistory());
        $this->assertEquals($this->order->getLastOrderHistory()->getState(), $orderInitialState);

        $orderHistories = $this->order->getOrderHistories();

        /**
         * @var OrderHistoryInterface $orderHistory
         */
        foreach ($orderHistories as $orderHistory) {

            $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface', $orderHistory);
            $this->assertEquals($orderHistory->getState(), $orderInitialState);
        }

        $this
            ->getObjectManager('order')
            ->clear();

        $this->assertCount(
            1,
            $this->findAll('order')
        );
    }

    /**
     * test createFromCart method when a cart is already ordered
     *
     * @group order
     */
    public function testCreateOrderFromCartOrdered()
    {
        /**
         * @var $order OrderInterface
         */
        $order = $this
            ->get('elcodi.cart_order_transformer')
            ->createOrderFromCart($this->cart);

        $this->assertEquals(2, $order->getOrderLines()->count());
    }
}
