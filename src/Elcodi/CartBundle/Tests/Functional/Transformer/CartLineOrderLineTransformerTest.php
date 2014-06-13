<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Tests\Functional\Transformer;

use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Transformer\CartLineOrderLineTransformer;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Transformer\CartOrderTransformer;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CoreBundle\Tests\WebTestCase;
use Elcodi\CartBundle\Entity\OrderLine;

/**
 * Class CartLineOrderLineTransformer
 */
class CartLineOrderLineTransformerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart.transformer.cart_line_order_line',
            'elcodi.cart_line_order_line_transformer',
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
            'ElcodiCoreBundle',
            'ElcodiCurrencyBundle',
            'ElcodiProductBundle',
            'ElcodiUserBundle',
            'ElcodiCartBundle',
        ];
    }

    /**
     * test create orderLine by CartLine
     *
     * @group order
     */
    public function testCreateOrderLineByCartLine()
    {
        /**
         * @var CartLineOrderLineTransformer $cartLineOrderLineTransformer
         * @var CartOrderTransformer $cartOrderTransformer
         */
        $cartLineOrderLineTransformer = $this
            ->container
            ->get('elcodi.cart_line_order_line_transformer');

        $cartOrderTransformer = $this
            ->container
            ->get('elcodi.cart_order_transformer');

        $orderInitialState = $this
            ->container
            ->getParameter('elcodi.core.cart.order_initial_state');

        /**
         * @var CartInterface $cart
         * @var CartLineInterface $cartLine
         * @var OrderLine $orderLine
         */
        $cart = $this
            ->getRepository('elcodi.core.cart.entity.cart.class')
            ->find(2);

        $this
            ->container
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartLoadEvents($cart);

        $cartLine = $cart->getCartLines()->first();
        $order = $cartOrderTransformer->createOrderFromCart($cart);
        $orderLine = $cartLineOrderLineTransformer
            ->createOrderLineByCartLine(
                $order,
                $cartLine
            );

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
