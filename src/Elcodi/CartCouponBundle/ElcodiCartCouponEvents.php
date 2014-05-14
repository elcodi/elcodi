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
     * This event is fired each time a coupon is going to be applied into a Cart
     *
     * event.name : coupon.cart_preapply
     * event.class : CouponCartPreApplyEvent
     */
    const COUPON_CART_PREAPPLY= 'coupon.cart_preapply';

    /**
     * This event is fired each time a coupon is applied and flushed into a Cart
     *
     * event.name : coupon.cart_prostapply
     * event.class : CouponCartPostApplyEvent
     */
    const COUPON_CART_POSTAPPLY = 'coupon.cart_postapply';

    /**
     * This event is fired each time a coupon is going to be removed from a Cart
     *
     * event.name : coupon.cart_preremove
     * event.class : CouponCartPreRemoveEvent
     */
    const COUPON_CART_PREREMOVE = 'coupon.cart_preremove';

    /**
     * This event is fired each time a coupon is removed from a Cart
     *
     * event.name : coupon.cart_postremove
     * event.class : CouponCartPostRemoveEvent
     */
    const COUPON_CART_POSTREMOVE = 'coupon.cart_postremove';
}
