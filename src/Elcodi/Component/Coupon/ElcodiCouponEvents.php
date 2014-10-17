<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\Coupon;

/**
 * Class ElcodiCouponEvents
 */
class ElcodiCouponEvents
{
    /**
     * This event is fired each time a coupon has been used
     *
     * event.name : coupon.onused
     * event.class : CouponOnUsedEvent
     */
    const COUPON_USED = 'coupon.onused';
}
