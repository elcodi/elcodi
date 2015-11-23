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

namespace Elcodi\Component\CartCoupon\Tests\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\CartCoupon\Exception\CouponNotStackableException;
use Elcodi\Component\CartCoupon\Services\StackableCouponChecker;

/**
 * Class StackableCouponCheckerTest
 */
class StackableCouponCheckerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test cart with stackable coupon and all stacked coupons are stackable
     *
     * @covers checkStackableCoupon
     *
     * @dataProvider dataCheckStackableCoupon
     */
    public function testCheckStackableCoupon(
        $couponStackable,
        $stackables,
        $expectsException
    ) {
        $cart = $this
            ->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface')
            ->reveal();

        $coupon = $this->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $coupon
            ->getStackable()
            ->willReturn($couponStackable);

        $cartCouponRepository = $this->prophesize('Elcodi\Component\CartCoupon\Repository\CartCouponRepository');
        $cartCouponRepository
            ->findBy(['cart' => $cart])
            ->willReturn($this->getCartCouponsArray($stackables));

        $stackableCouponChecker = new StackableCouponChecker(
            $cartCouponRepository->reveal()
        );

        try {
            $stackableCouponChecker
                ->checkStackableCoupon(
                    $cart,
                    $coupon->reveal()
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
            [true, [], false],
            [false, [], false],
            [false, [true, true], true],
            [false, [false, true], true],
            [true, [false, true], true],
            [true, [true, true], false],
        ];
    }

    /**
     * Private geta CartCoupon array given stackable information
     *
     * @return array Cart coupons
     */
    private function getCartCouponsArray(array $stackables)
    {
        $cartCoupons = [];
        foreach ($stackables as $stackable) {
            $coupon = $this->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');
            $cartCoupon = $this->prophesize('Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface');

            $coupon
                ->getStackable()
                ->willReturn($stackable);

            $cartCoupon
                ->getCoupon()
                ->willReturn($coupon->reveal());

            $cartCoupons[] = $cartCoupon->reveal();
        }

        return $cartCoupons;
    }
}
