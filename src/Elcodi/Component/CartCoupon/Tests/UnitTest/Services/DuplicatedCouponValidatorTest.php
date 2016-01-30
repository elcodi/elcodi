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

use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\CartCoupon\Exception\CouponAlreadyAppliedException;
use Elcodi\Component\CartCoupon\Services\DuplicatedCouponValidator;

/**
 * Class DuplicatedCouponValidatorTest.
 */
class DuplicatedCouponValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test checkDuplicates with duplication.
     *
     * @covers checkDuplicates
     * @dataProvider dataCheckDuplicates
     */
    public function testCheckDuplicates(
        CartCouponInterface $cartCoupon = null,
        $expectsException = true
    ) {
        $cartCouponRepository = $this->prophesize('Elcodi\Component\CartCoupon\Repository\CartCouponRepository');
        $cart = $this
            ->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface')
            ->reveal();

        $coupon = $this
            ->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface')
            ->reveal();

        $cartCouponRepository
            ->findOneBy([
                'cart' => $cart,
                'coupon' => $coupon,
            ])
            ->willReturn($cartCoupon);

        $duplicatedCouponChecker = new DuplicatedCouponValidator(
            $cartCouponRepository->reveal()
        );

        try {
            $duplicatedCouponChecker
                ->validateDuplicatedCoupon(
                    $cart,
                    $coupon
                );
        } catch (CouponAlreadyAppliedException $exception) {
            if (!$expectsException) {
                throw $exception;
            }
        }
    }

    /**
     * Data for testCheckDuplicates.
     */
    public function dataCheckDuplicates()
    {
        return [
            [null, false],
            [
                $this
                    ->prophesize('Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface')
                    ->reveal(),
                true,
            ],
        ];
    }
}
