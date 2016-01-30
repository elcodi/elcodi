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

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;

/**
 * Class ValidateCartCouponEventListener.
 */
final class ValidateCartCouponEventListener
{
    /**
     * @var CartCouponEventDispatcher
     *
     * Event dispatcher for CartCoupon
     */
    private $cartCouponDispatcher;

    /**
     * Construct method.
     *
     * @param CartCouponEventDispatcher $cartCouponDispatcher Event dispatcher for CartCoupon
     */
    public function __construct(CartCouponEventDispatcher $cartCouponDispatcher)
    {
        $this->cartCouponDispatcher = $cartCouponDispatcher;
    }

    /**
     * Checks if a Coupon is applicable to a Cart.
     *
     * @param CartCouponOnApplyEvent $event Event
     */
    public function validateCoupon(CartCouponOnApplyEvent $event)
    {
        $this
            ->cartCouponDispatcher
            ->dispatchCartCouponOnCheckEvent(
                $event->getCart(),
                $event->getCoupon()
            );
    }
}
