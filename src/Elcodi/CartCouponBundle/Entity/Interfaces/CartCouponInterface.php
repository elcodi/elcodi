<?php

/**
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

namespace Elcodi\CartCouponBundle\Entity\Interfaces;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;

/**
 * Class CartCouponInterface
 */
interface CartCouponInterface
{
    /**
     * Sets Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartCouponInterface Self object
     */
    public function setCart(CartInterface $cart);

    /**
     * Get Cart
     *
     * @return CartInterface Cart
     */
    public function getCart();

    /**
     * Sets Coupon
     *
     * @param CouponInterface $coupon Coupon
     *
     * @return CartCouponInterface Self object
     */
    public function setCoupon(CouponInterface $coupon);

    /**
     * Get Coupon
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon();
}
