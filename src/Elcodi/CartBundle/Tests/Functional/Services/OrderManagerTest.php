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

namespace Elcodi\CartBundle\Tests\Functional\Services;

use Elcodi\CartBundle\Entity\Cart;
use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Services\OrderManager;
use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Tests OrderManager class
 */
class OrderManagerTest extends WebTestCase
{
    /**
     * @var Cart
     *
     * Cart
     */
    protected $cart;

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.cart.services.order_manager';
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiCoreBundle',
            'ElcodiUserBundle',
            'ElcodiProductBundle',
            'ElcodiCartBundle',
        );
    }

    /**
     * setup
     */
    public function setUp()
    {
        parent::setUp();

        $this->cart = $this
            ->getRepository('elcodi.core.cart.entity.cart.class')
            ->find(2);
    }

    /**
     * test createFromCart method
     */
    public function testCreateFromCart()
    {
        /**
         * @var OrderManager $orderManager
         */
        $orderManager = $this->container->get('elcodi.core.cart.services.order_manager');
        $orderInitialState = $this->container->getParameter('elcodi.core.cart.order_initial_state');
        $order = $orderManager->createOrderFromCart($this->cart);

        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderInterface', $order);
        $this->assertSame($order->getCart(), $this->cart);
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

        $orderLines = $order->getOrderLines();

        /**
         * @var OrderLineInterface $orderLine
         */
        foreach ($orderLines as $orderLine) {
            $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface', $orderLine);
            $this->assertEquals($orderLine->getLastOrderLineHistory()->getState(), $orderInitialState);

            $orderLineHistories = $orderLine->getOrderLineHistories();

            /**
             * @var OrderLineHistoryInterface $orderLineHistory
             */
            foreach ($orderLineHistories as $orderLineHistory) {
                $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface', $orderLineHistory);
                $this->assertEquals($orderLineHistory->getState(), $orderInitialState);
            }
        }
    }

    /**
     * Test checkChangeToStateNotAllowed method
     *
     * @expectedException \Elcodi\CartBundle\Exception\OrderStateChangeNotReachableException
     */
    public function testCheckChangeToStateNotAllowed()
    {
        $orderManager = $this->container->get('elcodi.core.cart.services.order_manager');
        $order = $orderManager->createOrderFromCart($this->cart);
        $orderManager->toState($order, 'no-exists');
    }

    /**
     * Test checkChangeToStateAllowed
     */
    public function testCheckChangeToState()
    {
        /**
         * @var OrderManager $orderManager
         */
        $orderManager = $this->container->get('elcodi.core.cart.services.order_manager');
        $order = $orderManager->createOrderFromCart($this->cart);
        $orderManager->toState($order, 'accepted');
        $this->assertCount(2, $order->getOrderHistories());
        $this->assertSame($order->getLastOrderHistory(), $order->getOrderHistories()->last());
        $this->assertEquals('accepted', $order->getLastOrderHistory()->getState());

        $orderLines = $order->getOrderLines();

        /**
         * @var OrderLineInterface $orderLine
         */
        foreach ($orderLines as $orderLine) {

            $this->assertCount(2, $orderLine->getOrderLineHistories());
            $this->assertSame($orderLine->getLastOrderLineHistory(), $orderLine->getOrderLineHistories()->last());
            $this->assertEquals('accepted', $orderLine->getLastOrderLineHistory()->getState());
        }
    }
}
