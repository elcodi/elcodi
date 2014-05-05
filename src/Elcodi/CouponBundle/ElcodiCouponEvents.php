<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder##
 * @version ##version_placeholder##
 */
 
namespace Elcodi\CouponBundle;


/**
 * Class ElcodiCouponEvents
 */
class ElcodiCouponEvents
{
    /**
     * This event is fired each time a coupon has been used
     *
     * event.name : coupon.used
     * event.class : CouponUsedEvent
     */
    const COUPON_USED = 'coupon.used';
}
