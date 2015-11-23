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

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Exception\CouponNotStackableException;

/**
 * Class StackableCouponEventListenerTest
 */
class StackableCouponEventListenerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
            'ElcodiCouponBundle',
        ];
    }

    /**
     * Test cart with stackable coupon and all stacked coupons are stackable
     *
     * @covers       checkStackableCoupon
     *
     * @dataProvider dataCheckStackableCoupon
     */
    public function testCheckStackableCoupon(
        $couponIds,
        $expectsException
    ) {
        $this->reloadScenario();

        $cart = $this->find('cart', 2);
        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

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
    }

    /**
     * Data for testCheckStackableCoupon
     */
    public function dataCheckStackableCoupon()
    {
        return [
            [[1], false],
            [[3], false],
            [[3, 4], false],
            [[3, 1], true],
            [[1, 3], true],
        ];
    }

    /**
     * Private geta CartCoupon array given stackable information
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
}
