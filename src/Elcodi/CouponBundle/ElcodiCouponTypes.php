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

namespace Elcodi\CouponBundle;

/**
 * Class ElcodiCouponTypes
 */
class ElcodiCouponTypes
{
    /**
     * Coupon types
     */

    /**
     * @var int
     *
     * Cupon type absolute amount
     */
    const TYPE_AMOUNT = 1;

    /**
     * @var int
     *
     * Coupon type percent
     */
    const TYPE_PERCENT = 2;

    /**
     * Appliance type
     */

    /**
     * @var int
     *
     * Automatic enforcement
     */
    const ENFORCEMENT_AUTOMATIC = 1;

    /**
     * @var int
     *
     * Manual enforcement
     */
    const ENFORCEMENT_MANUAL = 2;
}
