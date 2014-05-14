<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Elcodi\CartCouponBundle\Tests\Functional\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Services\OrderManager;
use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class OrderEventListenerTest
 */
class OrderEventListenerTest extends WebTestCase
{
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
        return 'elcodi.core.cart_coupon.event_listeners.order';
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
         * @var CartInterface   $cart
         * @var OrderManager    $orderManager
         * @var OrderInterface  $order
         *
         * @var ArrayCollection $cartCoupons
         * @var ArrayCollection $orderCoupons
         */
        $cart = $this->manager->getRepository('ElcodiCartBundle:Cart')->find(2);
        $orderManager = $this->container->get('elcodi.core.cart.services.order_manager');
        $order = $orderManager->createOrderFromCart($cart);
        $this->assertEquals($cart->getCouponAmount(), $order->getCouponAmount());
        $cartCoupons = $this->container->get('elcodi.core.cart_coupon.services.cart_coupon_manager')->getCartCoupons($cart);
        $orderCoupons = $this->container->get('elcodi.core.cart_coupon.services.order_coupon_manager')->getOrderCoupons($order);

        $this->assertEquals($cartCoupons->count(), $orderCoupons->count());
        $this->assertTrue($cartCoupons->forAll(function ($_, $cartCoupon) use ($orderCoupons) {
            return $orderCoupons->exists(function ($_, $orderCoupon) use ($cartCoupon) {

                return $cartCoupon->getId() === $orderCoupon->getId();
            });
        }));
    }
}
