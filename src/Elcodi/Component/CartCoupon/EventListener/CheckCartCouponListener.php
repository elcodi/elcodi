<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;

/**
 * Class CheckCartCouponListener
 */
class CheckCartCouponListener
{
    /**
     * @var CartCouponEventDispatcher
     *
     * Event dispatcher for CartCoupon
     */
    protected $cartCouponDispatcher;

    /**
     * Construct method
     *
     * @param CartCouponEventDispatcher $cartCouponDispatcher Event dispatcher for CartCoupon
     */
    public function __construct(CartCouponEventDispatcher $cartCouponDispatcher)
    {
        $this->cartCouponDispatcher = $cartCouponDispatcher;
    }

    /**
     * Checks if a Coupon is applicable to a Cart
     *
     * @param CartCouponOnApplyEvent $event
     *
     * @return boolean true if the coupon applies, false otherwise
     *
     */
    public function checkCoupon(CartCouponOnApplyEvent $event)
    {
        $this
            ->cartCouponDispatcher
            ->dispatchCartCouponOnCheckEvent(
                $event->getCart(),
                $event->getCoupon()
            );
    }
}
