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

namespace Elcodi\Component\CartCoupon\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class AbstractCartCouponEvent.
 */
abstract class AbstractCartCouponEvent extends Event
{
    /**
     * @var CartInterface
     *
     * Cart
     */
    private $cart;

    /**
     * @var CouponInterface
     *
     * Coupon
     */
    private $coupon;

    /**
     * @var CartCouponInterface
     *
     * CartCoupon
     */
    private $cartCoupon;

    /**
     * Construct method.
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
     * Set CartCoupon.
     *
     * @param CartCouponInterface $cartCoupon CartCoupon
     *
     * @return $this Self object
     */
    public function setCartCoupon(CartCouponInterface $cartCoupon)
    {
        $this->cartCoupon = $cartCoupon;

        return $this;
    }

    /**
     * Return cart.
     *
     * @return CartInterface $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Return Coupon.
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Get CartCoupon.
     *
     * @return CartCouponInterface|null Cart Coupon
     */
    public function getCartCoupon()
    {
        return $this->cartCoupon;
    }
}
