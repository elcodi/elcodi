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

namespace Elcodi\CartCouponBundle\Event\Abstracts;

use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Symfony\Component\EventDispatcher\Event;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;

/**
 * AbstractCartCouponEvent class
 */
abstract class AbstractCartCouponEvent extends Event
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
     * @var CartCouponInterface
     *
     * CartCoupon
     */
    protected $cartCoupon;

    /**
     * Construct method
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     */
    public function __construct(CartInterface $cart, CouponInterface $coupon)
    {
        $this->cart = $cart;
        $this->coupon = $coupon;
    }

    /**
     * Set CartCoupon
     *
     * @param CartCouponInterface $cartCoupon CartCoupon
     *
     * @return AbstractCartCouponEvent self Object
     */
    public function setCartCoupon(CartCouponInterface $cartCoupon)
    {
        $this->cartCoupon = $cartCoupon;

        return $this;
    }

    /**
     * Return cart
     *
     * @return CartInterface $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Return Coupon
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Get CartCoupon
     *
     * @return CartCouponInterface|null Cart Coupon
     */
    public function getCartCoupon()
    {
        return $this->cartCoupon;
    }
}
