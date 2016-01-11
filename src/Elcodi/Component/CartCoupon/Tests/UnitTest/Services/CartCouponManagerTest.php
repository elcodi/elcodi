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
use Prophecy\Argument;

use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;
use Elcodi\Component\CartCoupon\Repository\CartCouponRepository;
use Elcodi\Component\CartCoupon\Services\CartCouponManager;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Coupon\Repository\CouponRepository;

/**
 * Class CartCouponManagerTest.
 */
class CartCouponManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CartCouponEventDispatcher
     *
     * CartCoupon Event dispatcher
     */
    private $cartCouponEventDispatcher;

    /**
     * @var CouponRepository
     *
     * Coupon Repository
     */
    private $couponRepository;

    /**
     * @var ObjectDirector
     *
     * CartCoupon director
     */
    private $cartCouponDirector;

    /**
     * @var CartCouponRepository
     *
     * CartCoupon repository
     */
    private $cartCouponRepository;

    /**
     * Setup.
     */
    public function setUp()
    {
        $this->cartCouponEventDispatcher = $this->prophesize('Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher');
        $this->couponRepository = $this->prophesize('Elcodi\Component\Coupon\Repository\CouponRepository');
        $this->cartCouponDirector = $this->prophesize('Elcodi\Component\Core\Services\ObjectDirector');
        $this->cartCouponRepository = $this->prophesize('Elcodi\Component\CartCoupon\Repository\CartCouponRepository');
    }

    /**
     * Test create and save.
     *
     * @covers createAndSaveCartCoupon
     */
    public function testCreateAndSaveCartCoupon()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $coupon = $this->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');
        $cartCoupon = $this
            ->prophesize('Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface')
            ->reveal();

        $this
            ->cartCouponDirector
            ->create(Argument::any())
            ->willReturn($cartCoupon)
            ->shouldBeCalled();

        $this
            ->cartCouponDirector
            ->save($cartCoupon)
            ->shouldBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $cartCouponManager
            ->createAndSaveCartCoupon(
                $cart->reveal(),
                $coupon->reveal()
            );
    }

    /**
     * Test getCartCoupons.
     *
     * @covers getCartCoupons
     */
    public function testGetCartCouponsCartWithoutId()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart
            ->getId()
            ->willReturn(null);

        $this
            ->cartCouponRepository
            ->findCartCouponsByCart(Argument::any())
            ->shouldNotBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $result = $cartCouponManager->getCartCoupons($cart->reveal());
        $this->assertEmpty($result);
    }

    /**
     * Test getCartCoupons.
     *
     * @covers getCartCoupons
     */
    public function testGetCouponsCartWithId()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart
            ->getId()
            ->willReturn(1);

        $this
            ->cartCouponRepository
            ->findCartCouponsByCart(Argument::any())
            ->shouldBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $cartCouponManager->getCartCoupons($cart->reveal());
    }

    /**
     * Test getCartCoupons.
     *
     * @covers getCoupons
     */
    public function testGetCouponsCartWithoutId()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart
            ->getId()
            ->willReturn(null);

        $this
            ->cartCouponRepository
            ->findCouponsByCart(Argument::any())
            ->shouldNotBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $result = $cartCouponManager->getCoupons($cart->reveal());
        $this->assertEmpty($result);
    }

    /**
     * Test getCartCoupons.
     *
     * @covers getCoupons
     */
    public function testGetCartCouponsCartWithId()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart
            ->getId()
            ->willReturn(1);

        $this
            ->cartCouponRepository
            ->findCouponsByCart(Argument::any())
            ->shouldBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $cartCouponManager->getCoupons($cart->reveal());
    }

    /**
     * Test add coupon by code.
     *
     * @covers addCouponByCode
     *
     * @expectedException \Elcodi\Component\Coupon\Exception\CouponNotAvailableException
     */
    public function testAddNonExistingCouponByCode()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');

        $this
            ->cartCouponEventDispatcher
            ->dispatchCartCouponOnApplyEvent(
                Argument::any(),
                Argument::any()
            )
            ->shouldNotBeCalled();

        $this
            ->couponRepository
            ->findOneBy(Argument::any())
            ->willReturn(null);

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $cartCouponManager->addCouponByCode(
            $cart->reveal(),
            1
        );
    }

    /**
     * Test add coupon by code.
     *
     * @covers addCouponByCode
     */
    public function testAddExistingCouponByCode()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $coupon = $this->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $this
            ->cartCouponEventDispatcher
            ->dispatchCartCouponOnApplyEvent(
                Argument::any(),
                Argument::any()
            )
            ->shouldBeCalled();

        $this
            ->couponRepository
            ->findOneBy(Argument::any())
            ->willReturn($coupon->reveal());

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $cartCouponManager->addCouponByCode(
            $cart->reveal(),
            1
        );
    }

    /**
     * Test add coupon by code.
     *
     * @covers addCouponByCode
     */
    public function testAddCoupon()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $coupon = $this->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $this
            ->cartCouponEventDispatcher
            ->dispatchCartCouponOnApplyEvent(
                Argument::any(),
                Argument::any()
            )
            ->shouldBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $cartCouponManager->addCoupon(
            $cart->reveal(),
            $coupon->reveal()
        );
    }

    /**
     * Test add coupon by code.
     *
     * @covers removeCouponByCode
     */
    public function testRemoveNonExistingCouponByCode()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');

        $this
            ->cartCouponEventDispatcher
            ->dispatchCartCouponOnRemoveEvent(
                Argument::any(),
                Argument::any()
            )
            ->shouldNotBeCalled();

        $this
            ->couponRepository
            ->findOneBy(Argument::any())
            ->willReturn(null)
            ->shouldBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $result = $cartCouponManager->removeCouponByCode(
            $cart->reveal(),
            1
        );
        $this->assertFalse($result);
    }

    /**
     * Test add coupon by code.
     *
     * @covers removeCouponByCode
     * @covers removeCoupon
     */
    public function testRemoveExistingCouponByCodeNonExistingCartCoupons()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $coupon = $this->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $this
            ->cartCouponEventDispatcher
            ->dispatchCartCouponOnRemoveEvent(
                Argument::any(),
                Argument::any()
            )
            ->shouldNotBeCalled();

        $this
            ->couponRepository
            ->findOneBy(Argument::any())
            ->willReturn($coupon->reveal())
            ->shouldBeCalled();

        $this
            ->cartCouponDirector
            ->findBy(Argument::any())
            ->willReturn([])
            ->shouldBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $result = $cartCouponManager->removeCouponByCode(
            $cart->reveal(),
            1
        );

        $this->assertFalse($result);
    }

    /**
     * Test add coupon by code.
     *
     * @covers removeCouponByCode
     * @covers removeCoupon
     */
    public function testRemoveExistingCouponByCodeExistingCartCoupons()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $coupon = $this->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');
        $cartCoupon1 = $this->prophesize('Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface');
        $cartCoupon2 = $this->prophesize('Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface');
        $cartCoupons = [
            $cartCoupon1->reveal(),
            $cartCoupon2->reveal(),
        ];

        $this
            ->cartCouponEventDispatcher
            ->dispatchCartCouponOnRemoveEvent(
                Argument::any(),
                Argument::any()
            )
            ->shouldBeCalledTimes(2);

        $this
            ->couponRepository
            ->findOneBy(Argument::any())
            ->willReturn($coupon->reveal())
            ->shouldBeCalled();

        $this
            ->cartCouponDirector
            ->findBy(Argument::any())
            ->willReturn($cartCoupons)
            ->shouldBeCalled();

        $cartCouponManager = $this->createCartCouponManagerInstance();
        $result = $cartCouponManager->removeCouponByCode(
            $cart->reveal(),
            1
        );

        $this->assertTrue($result);
    }

    /**
     * Test remove cart coupon.
     *
     * @covers removeCartCoupon
     */
    public function testRemoveCartCoupon()
    {
        $cartCoupon = $this
            ->prophesize('Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface')
            ->reveal();

        $this
            ->cartCouponDirector
            ->remove($cartCoupon)
            ->shouldBeCalled();

        $this
            ->createCartCouponManagerInstance()
            ->removeCartCoupon($cartCoupon);
    }

    /**
     * Create new CartCouponManager instance.
     *
     * @return CartCouponManager
     */
    private function createCartCouponManagerInstance()
    {
        return new CartCouponManager(
            $this->cartCouponEventDispatcher->reveal(),
            $this->couponRepository->reveal(),
            $this->cartCouponDirector->reveal(),
            $this->cartCouponRepository->reveal()
        );
    }
}
