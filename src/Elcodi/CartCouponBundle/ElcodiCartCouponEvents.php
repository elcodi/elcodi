<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle;

/**
 * ElcodiCartCouponEvents
 */
class ElcodiCartCouponEvents
{

    /**
     * This event is fired each time a coupon is applied into a Cart
     *
     * event.name : coupon.applied_to_cart
     * event.class : CouponAppliedToCartEvent
     */
    const COUPON_APPLIED_TO_CART = 'coupon.applied_to_cart';

    /**
     * This event is fired each time a coupon is removed from a Cart
     *
     * event.name : coupon.removed_from_cart
     * event.class : CouponRemovedFromCartEvent
     */
    const COUPON_REMOVED_FROM_CART = 'coupon.removed_from_cart';
}
