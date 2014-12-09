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

namespace Elcodi\Bundle\CartBundle\Tests\Functional\Transformer;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Entity\OrderLine;
use Elcodi\Component\Cart\Transformer\CartLineOrderLineTransformer;
use Elcodi\Component\Cart\Transformer\CartOrderTransformer;

/**
 * Class CartLineOrderLineTransformer
 */
class CartLineOrderLineTransformerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
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
         * @var CartOrderTransformer         $cartOrderTransformer
         */
        $cartLineOrderLineTransformer = $this
            ->get('elcodi.cart_line_order_line_transformer');

        $cartOrderTransformer = $this
            ->get('elcodi.cart_order_transformer');

        /**
         * @var CartInterface     $cart
         * @var CartLineInterface $cartLine
         * @var OrderLine         $orderLine
         */
        $cart = $this->find('cart', 2);

        $this
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartLoadEvents($cart);

        $cartLine = $cart->getCartLines()->first();
        $order = $cartOrderTransformer->createOrderFromCart($cart);
        $orderLine = $cartLineOrderLineTransformer
            ->createOrderLineByCartLine(
                $order,
                $cartLine
            );

        $this->assertInstanceOf('Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface', $orderLine);
    }
}
