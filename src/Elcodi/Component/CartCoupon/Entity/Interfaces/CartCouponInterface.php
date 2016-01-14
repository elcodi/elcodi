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

namespace Elcodi\Component\CartCoupon\Entity\Interfaces;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Interface CartCouponInterface.
 */
interface CartCouponInterface extends IdentifiableInterface
{
    /**
     * Get Cart.
     *
     * @return CartInterface Cart
     */
    public function getCart();

    /**
     * Sets Cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function setCart(CartInterface $cart);

    /**
     * Get Coupon.
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon();

    /**
     * Sets Coupon.
     *
     * @param CouponInterface $coupon Coupon
     *
     * @return $this Self object
     */
    public function setCoupon(CouponInterface $coupon);
}
