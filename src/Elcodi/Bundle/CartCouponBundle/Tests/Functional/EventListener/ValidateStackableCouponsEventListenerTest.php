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

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener;

use Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener\Abstracts\AbstractCartCouponEventListenerTest;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Exception\CouponNotStackableException;

/**
 * Class ValidateStackableCouponsEventListenerTest.
 */
class ValidateStackableCouponsEventListenerTest extends AbstractCartCouponEventListenerTest
{
    /**
     * Test cart with stackable coupon and all stacked coupons are stackable.
     *
     * @dataProvider dataValidateStackableCoupon
     */
    public function testValidateStackableCoupon(
        $couponIds,
        $expectsException
    ) {
        $cart = $this->getLoadedCart(2);

        try {
            $this
                ->addCouponsToCartByCouponIds(
                    $cart,
                    $couponIds
                );
        } catch (CouponNotStackableException $exception) {
            if (!$expectsException) {
                throw $exception;
            }
        }

        /**
         * Clean operations to avoid restart scenario.
         */
        $this->removeCouponsToCartByCouponIds(
            $cart,
            $couponIds
        );
    }

    /**
     * Data for testValidateStackableCoupon.
     */
    public function dataValidateStackableCoupon()
    {
        return [

            // Try to apply non stackable. Should be OK
            [[1], false],

            // Try to apply stackable. Should be OK
            [[3], false],

            // Try to apply two stackables. Should be OK
            [[3, 4], false],

            // Try to apply a non stackable after a stackable. Should throw Exception
            [[3, 1], true],

            // Try to apply a stackable after a non stackable. Should throw Exception
            [[1, 3], true],
        ];
    }

    /**
     * Add a set of coupons into a cart given their ids.
     */
    private function addCouponsToCartByCouponIds(
        CartInterface $cart,
        array $couponIds
    ) {
        $cartCouponManager = $this->get('elcodi.manager.cart_coupon');
        foreach ($couponIds as $couponId) {
            $coupon = $this->find('coupon', $couponId);
            $coupon->setEnabled(true);
            $cartCouponManager
                ->addCoupon(
                    $cart,
                    $coupon
                );
        }
    }

    /**
     * Remove a set of coupons from a cart given their ids.
     */
    private function removeCouponsToCartByCouponIds(
        CartInterface $cart,
        array $couponIds
    ) {
        $cartCouponManager = $this->get('elcodi.manager.cart_coupon');
        foreach ($couponIds as $couponId) {
            $coupon = $this->find('coupon', $couponId);
            $cartCouponManager
                ->removeCoupon(
                    $cart,
                    $coupon
                );
        }
    }
}
