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

namespace Elcodi\Component\CartCoupon;

/**
 * ElcodiCartCouponEvents.
 */
final class ElcodiCartCouponEvents
{
    /**
     * This event is dispatched while checking if a Coupon applies to a Cart.
     *
     * event.name : cart_coupon.oncheck
     * event.class : CartCouponOnCheckEvent
     */
    const CART_COUPON_ONCHECK = 'cart_coupon.oncheck';

    /**
     * This event is dispatched each time a coupon is applied into a Cart.
     *
     * event.name : cart_coupon.onapply
     * event.class : CartCouponOnApplyEvent
     */
    const CART_COUPON_ONAPPLY = 'cart_coupon.onapply';

    /**
     * This event is dispatched each time a coupon is removed from a Cart.
     *
     * event.name : cart_coupon.onremove
     * event.class : CartCouponOnRemoveEvent
     */
    const CART_COUPON_ONREMOVE = 'cart_coupon.onremove';

    /**
     * This event is dispatched each time a coupon is rejected from a Cart.
     *
     * event.name : cart_coupon.onrejected
     * event.class : CartCouponOnRejectedEvent
     */
    const CART_COUPON_ONREJECTED = 'cart_coupon.onrejected';

    /**
     * This event is dispatched each time a coupon is applied into an Order.
     *
     * event.name : order_coupon.onapply
     * event.class : OrderCouponOnApplyEvent
     */
    const ORDER_COUPON_ONAPPLY = 'order_coupon.onapply';
}
