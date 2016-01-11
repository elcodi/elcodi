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

namespace Elcodi\Component\Coupon;

/**
 * Class ElcodiCouponTypes.
 */
final class ElcodiCouponTypes
{
    /**
     * @var int
     *
     * Coupon type absolute amount
     */
    const TYPE_AMOUNT = 1;

    /**
     * @var int
     *
     * Coupon type percent
     */
    const TYPE_PERCENT = 2;

    /**
     * Appliance type.
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
