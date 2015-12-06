<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\CartBundle\Tests\Functional\Transformer;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Transformer\CartOrderTransformer;

/**
 * Class CartOrderTransformerTest.
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
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
        ];
    }

    /**
     * Setup.
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var CartOrderTransformer $cartOrderTransformer
         */
        $cartOrderTransformer = $this->get('elcodi.transformer.cart_order');

        /**
         * @var CartInterface $cart
         */
        $this->cart = $this->find('cart', 2);

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($this->cart);

        $this->order = $cartOrderTransformer->createOrderFromCart($this->cart);
    }

    /**
     * test createFromCart method when a cart is already ordered.
     *
     * @group order
     */
    public function testCreateOrderFromCartOrdered()
    {
        /**
         * @var $order OrderInterface
         */
        $order = $this
            ->get('elcodi.transformer.cart_order')
            ->createOrderFromCart($this->cart);

        $this->assertEquals(2, $order->getOrderLines()->count());
    }
}
