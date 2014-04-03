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

namespace Elcodi\CartCouponBundle\Entity;

use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;

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
