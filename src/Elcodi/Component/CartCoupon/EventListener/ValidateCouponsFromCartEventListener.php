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

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\CartCoupon\Services\CartCouponValidator;

/**
 * Class ValidateCouponsFromCartEventListener.
 *
 * This event listener should update the cart given in the event, applying
 * all the coupon features.
 */
final class ValidateCouponsFromCartEventListener
{
    /**
     * @var CartCouponValidator
     *
     * Cart coupon validator
     */
    private $cartCouponValidator;

    /**
     * Construct.
     *
     * @param CartCouponValidator $cartCouponValidator Cart Coupon validator
     */
    public function __construct(CartCouponValidator $cartCouponValidator)
    {
        $this->cartCouponValidator = $cartCouponValidator;
    }

    /**
     * Method subscribed to CartLoad event.
     *
     * Checks if all Coupons applied to current cart are still valid.
     * If are not, they will be deleted from the Cart and new Event typeof
     * CartCouponOnRejected will be dispatched
     *
     * @param CartOnLoadEvent $event Event
     */
    public function refreshCartCoupons(CartOnLoadEvent $event)
    {
        $this
            ->cartCouponValidator
            ->validateCartCoupons(
                $event->getCart()
            );
    }
}
