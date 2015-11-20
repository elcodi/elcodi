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
use Elcodi\Component\Cart\Entity\Cart;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\CartCoupon\Services\CartCouponManager;
use Elcodi\Component\Coupon\Entity\Coupon;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class CartCouponStackableEventListenerTest
 */
class CartCouponStackableEventListenerTest extends WebTestCase
{
    /**
     * @var Cart
     *
     * Cart
     */
    protected $cart;

    /**
     * @var CartCouponManager
     *
     * Cart Coupon manager
     */
    protected $cartCouponManager;

    /**
     * @var CartEventDispatcher
     *
     * Cart event dispatcher
     */
    protected $cartEventDispatcher;

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

    public function setUp()
    {
        $this->reloadScenario();

        parent::setUp();

        /**
         * Full cart from fixtures
         *
         * @var CartInterface $cart
         * @var CouponInterface $coupon
         */
        $this->cart = $this->find('cart', 2);

        $this
            ->cartEventDispatcher = $this->get('elcodi.event_dispatcher.cart');
        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($this->cart);

        $this->cartCouponManager = $this->get('elcodi.manager.cart_coupon');
    }

    /**
     * @expectedException \Elcodi\Component\CartCoupon\Exception\CouponNotStackableException
     */
    public function testAddNotStackableCouponThrowsException()
    {
        /**
         * Coupons from fixtures
         *
         * @var Coupon $couponPercent
         * @var Coupon $couponAmount
         */
        $couponPercent = $this->find('coupon', 1);
        $couponAmount = $this->find('coupon', 2);

        $this
            ->cartCouponManager
            ->addCoupon($this->cart, $couponPercent->setEnabled(true));

        /**
         * Adding a non-stackable coupon should throw an exception here
         */
        $this
            ->cartCouponManager
            ->addCoupon($this->cart, $couponAmount->setEnabled(true));
    }

    /**
     * @expectedException \Elcodi\Component\CartCoupon\Exception\CouponNotStackableException
     */
    public function testAddStackableCouponToANotStackableCouponThrowsException()
    {
        /**
         * Coupons from fixtures
         *
         * @var Coupon $couponPercent
         * @var Coupon $stackableCouponPercent
         */
        $couponPercent = $this->find('coupon', 1);
        $stackableCouponPercent = $this->find('coupon', 3);

        $this
            ->cartCouponManager
            ->addCoupon($this->cart, $couponPercent->setEnabled(true));

        /**
         * Adding a stackable coupon should throw an exception here,
         * since we already applied a non-stackable one
         */
        $this
            ->cartCouponManager
            ->addCoupon($this->cart, $stackableCouponPercent->setEnabled(true));
    }

    /**
     * test StackableCouponCalculatedAmount
     */
    public function testStackableCouponCalculatedAmount()
    {
        /**
         * Stackable Coupons from fixtures
         *
         * id 3: 12 % discount
         * id 4: 2 USD discount
         *
         * See CouponData fixtures for details
         *
         * @var Coupon $stacableCouponPercent
         * @var Coupon $stackableCouponAmount
         */
        $stackableCouponPercent = $this->find('coupon', 3);
        $stackableCouponAmount = $this->find('coupon', 4);

        $this
            ->cartCouponManager
            ->addCoupon($this->cart, $stackableCouponPercent->setEnabled(true));
        $this
            ->cartCouponManager
            ->addCoupon($this->cart, $stackableCouponAmount->setEnabled(true));

        /**
         * Dispatching cart.load events will recalculate
         * cart coupon amount
         */
        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($this->cart);

        $appliedCouponsAmount = $this->cart->getCouponAmount()->getAmount();

        $this->assertEquals(
            560,
            $appliedCouponsAmount
        );
    }
}
