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

namespace Elcodi\Component\CartCoupon\Tests\UnitTest\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\CartCoupon\Exception\CouponNotStackableException;
use Elcodi\Component\CartCoupon\Services\StackableCouponValidator;

/**
 * Class StackableCouponValidatorTest.
 */
class StackableCouponValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test cart with stackable coupon and all stacked coupons are stackable.
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

        $stackableCouponChecker = new StackableCouponValidator(
            $cartCouponRepository->reveal()
        );

        try {
            $stackableCouponChecker
                ->validateStackableCoupon(
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
     * Data for testCheckStackableCoupon.
     */
    public function dataCheckStackableCoupon()
    {
        return [
            // Try to apply stackable coupon with none applied. Should be OK
            [true, [], false],

            // Try to apply non stackable coupon with none applied. Should be OK
            [false, [], false],

            // Try to apply non stackable coupon with all stackable. Should throw exception
            [false, [true, true], true],

            // Try to apply non stackable coupon with one non stackable. Should throw exception
            [false, [false, true], true],

            // Try to apply stackable coupon with one non stackable. Should throw exception
            [true, [false, true], true],

            // Try to apply stackable coupon with all stackables. Should be OK
            [true, [true, true], false],
        ];
    }

    /**
     * Private geta CartCoupon array given stackable information.
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
