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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Transformer\CartOrderTransformer;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface;

/**
 * Class OrderEventListenerTest
 */
class OrderEventListenerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return ['elcodi.event_listener.cart_coupon.convert_to_order'];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiUserBundle',
            'ElcodiCurrencyBundle',
            'ElcodiAttributeBundle',
            'ElcodiProductBundle',
            'ElcodiCurrencyBundle',
            'ElcodiCartBundle',
            'ElcodiCouponBundle',
            'ElcodiCartCouponBundle',
        );
    }

    /**
     * Test onOrderOnCreatedEventCouponsValue
     */
    public function testOnOrderOnCreated()
    {
        /**
         * @var CartInterface        $cart
         * @var CartOrderTransformer $cartOrderTransformer
         * @var OrderInterface       $order
         *
         * @var ArrayCollection      $cartCoupons
         * @var ArrayCollection      $orderCoupons
         */
        $cart = $this->find('cart', 2);

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $cartOrderTransformer = $this
            ->get('elcodi.transformer.cart_order');

        $order = $cartOrderTransformer->createOrderFromCart($cart);

        $this->assertEquals(
            $cart->getCouponAmount(),
            $order->getCouponAmount()
        );

        $cartCoupons = $this
            ->get('elcodi.manager.cart_coupon')
            ->getCartCoupons($cart);

        $orderCoupons = $this
            ->get('elcodi.manager.order_coupon')
            ->getOrderCoupons($order);

        $this->assertEquals(
            $cartCoupons->count(),
            $orderCoupons->count()
        );

        $this->assertTrue(
            $cartCoupons->forAll(function ($_, CartCouponInterface $cartCoupon) use ($orderCoupons) {
                return $orderCoupons->exists(function ($_, OrderCouponInterface $orderCoupon) use ($cartCoupon) {

                    return $cartCoupon->getId() === $orderCoupon->getId();
                });
            })
        );
    }
}
