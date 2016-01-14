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

/**
 * Class ValidateCouponEventListenerTest.
 */
class ValidateCouponEventListenerTest extends AbstractCartCouponEventListenerTest
{
    /**
     * Test duplicated coupons with invalid card.
     *
     * @expectedException \Elcodi\Component\Coupon\Exception\CouponIncompatibleException
     */
    public function testDuplicatedCouponWithoutProducts()
    {
        $cart = $this->getLoadedCart(1);
        $coupon = $this->getEnabledCoupon(3);

        $this
            ->get('elcodi.manager.cart_coupon')
            ->addCoupon(
                $cart,
                $coupon
            );
    }

    /**
     * Test duplicated coupons with non active/enabled coupon.
     *
     * @expectedException \Elcodi\Component\Coupon\Exception\CouponNotActiveException
     */
    public function testDuplicatedCouponNotActive()
    {
        $this->reloadScenario();
        $cart = $this->getLoadedCart(2);
        $coupon = $this->find('coupon', 3);

        $this
            ->get('elcodi.manager.cart_coupon')
            ->addCoupon(
                $cart,
                $coupon
            );
    }

    /**
     * Test duplicated coupons with non usable coupon.
     *
     * @expectedException \Elcodi\Component\Coupon\Exception\CouponAppliedException
     */
    public function testDuplicatedCouponNotUsable()
    {
        $this->reloadScenario();
        $cart = $this->getLoadedCart(2);
        $coupon = $this
            ->getEnabledCoupon(3)
            ->setCount(100)
            ->setUsed(100);

        $this
            ->get('elcodi.manager.cart_coupon')
            ->addCoupon(
                $cart,
                $coupon
            );
    }
}
