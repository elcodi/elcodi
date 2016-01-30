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

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\CartCoupon\Services\AutomaticCouponApplicator;

/**
 * Class AutomaticCouponApplicatorTest.
 */
class AutomaticCouponApplicatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test empty cart.
     *
     * @covers tryAutomaticCoupons
     */
    public function testEmptyCart()
    {
        $cartCouponManager = $this->prophesize('Elcodi\Component\CartCoupon\Services\CartCouponManager');

        $couponRepository = $this->prophesize('Doctrine\Common\Persistence\ObjectRepository');
        $couponRepository
            ->findBy(Argument::any())
            ->shouldNotBeCalled();

        $cartLines = new ArrayCollection();
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart
            ->getCartLines()
            ->willReturn($cartLines);

        $automaticCouponApplicator = new AutomaticCouponApplicator(
            $cartCouponManager->reveal(),
            $couponRepository->reveal()
        );

        $automaticCouponApplicator->tryAutomaticCoupons($cart->reveal());
    }
}
