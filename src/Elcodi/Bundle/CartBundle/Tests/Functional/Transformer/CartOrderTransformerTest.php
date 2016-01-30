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

namespace Elcodi\Bundle\CartBundle\Tests\Functional\Transformer;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;

/**
 * Class CartOrderTransformerTest.
 */
class CartOrderTransformerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
            'ElcodiProductBundle',
        ];
    }

    /**
     * test createFromCart method.
     */
    public function testCreateOrderFromCart()
    {
        /**
         * @var CartInterface $cart
         */
        $cart = $this->find('cart', 2);

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        /**
         * @var $order OrderInterface
         */
        $order = $this
            ->get('elcodi.transformer.cart_order')
            ->createOrderFromCart($cart);

        $this->assertEquals(2, $order
            ->getOrderLines()
            ->count()
        );
    }

    /**
     * Test createFromCart with complex scenario.
     */
    public function testCreateOrderFromCartComplex()
    {
        $cart = $this->find('cart', 1);

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $cartManager = $this->get('elcodi.manager.cart');
        $cartManager->addPurchasable(
            $cart,
            $this->find('product', 1),
            1
        );

        $cartManager->addPurchasable(
            $cart,
            $this->find('product_variant', 7),
            1
        );

        $cartManager->addPurchasable(
            $cart,
            $this->find('purchasable_pack', 9),
            1
        );

        /**
         * @var $order OrderInterface
         */
        $order = $this
            ->get('elcodi.transformer.cart_order')
            ->createOrderFromCart($cart);

        $this->assertEquals(3, $order
            ->getOrderLines()
            ->count()
        );

        $this->assertEquals(7500, $order
            ->getAmount()
            ->getAmount()
        );
    }
}
