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

namespace Elcodi\Component\CartCoupon\Applicator\Interfaces;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Interface CartCouponApplicatorInterface.
 */
interface CartCouponApplicatorInterface
{
    /**
     * Get the id of the Applicator.
     *
     * @return string Applicator id
     */
    public static function id();

    /**
     * Can be applied.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return bool Can be applied
     */
    public function canBeApplied(
        CartInterface $cart,
        CouponInterface $coupon
    );

    /**
     * Calculate coupon absolute value.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return MoneyInterface|false Absolute value for this coupon in this cart.
     */
    public function getCouponAbsoluteValue(
        CartInterface $cart,
        CouponInterface $coupon
    );
}
