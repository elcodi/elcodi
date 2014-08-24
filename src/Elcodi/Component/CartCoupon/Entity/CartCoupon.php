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

namespace Elcodi\Component\CartCoupon\Entity;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class CartCoupon
 */
class CartCoupon extends AbstractEntity implements CartCouponInterface
{
    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * @var CouponInterface
     *
     * Coupon
     */
    protected $coupon;

    /**
     * Sets Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartCoupon Self object
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get Cart
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Sets Coupon
     *
     * @param CouponInterface $coupon Coupon
     *
     * @return CartCoupon Self object
     */
    public function setCoupon(CouponInterface $coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * Get Coupon
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }
}
