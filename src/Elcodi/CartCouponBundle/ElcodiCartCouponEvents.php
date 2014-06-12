<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle;

/**
 * ElcodiCartCouponEvents
 */
class ElcodiCartCouponEvents
{
    /**
     * This event is dispatched each time a coupon is applied into a Cart
     *
     * event.name : cart_coupon.onapply
     * event.class : CartCouponOnApplyEvent
     */
    const CART_COUPON_ONAPPLY= 'cart_coupon.onapply';

    /**
     * This event is dispatched each time a coupon is removed from a Cart
     *
     * event.name : cart_coupon.onremove
     * event.class : CartCouponOnRemoveEvent
     */
    const CART_COUPON_ONREMOVE = 'cart_coupon.onremove';

    /**
     * This event is dispatched each time a coupon is applied into an Order
     *
     * event.name : order_coupon.onapply
     * event.class : OrderCouponOnApplyEvent
     */
    const ORDER_COUPON_ONAPPLY= 'order_coupon.onapply';
}
