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

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Exception\CouponNotStackableException;
use Elcodi\Component\CartCoupon\Services\StackableCouponChecker;

/**
 * Class CheckStackableCouponsEventListener
 */
class CheckStackableCouponsEventListener
{
    /**
     * @var StackableCouponChecker
     *
     * Stackable Coupon Checker
     */
    private $stackableCouponChecker;

    /**
     * Construct method
     *
     * @param StackableCouponChecker $stackableCouponChecker Stackable Coupon Checker
     */
    public function __construct(StackableCouponChecker $stackableCouponChecker)
    {
        $this->stackableCouponChecker = $stackableCouponChecker;
    }

    /**
     * Check if this coupon can be applied when other coupons had previously
     * been applied
     *
     * @param CartCouponOnApplyEvent $event Event
     *
     * @return null
     *
     * @throws CouponNotStackableException
     */
    public function checkStackableCoupon(CartCouponOnApplyEvent $event)
    {
        $this
            ->stackableCouponChecker
            ->checkStackableCoupon(
                $event->getCart(),
                $event->getCoupon()
            );
    }
}
