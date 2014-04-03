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

namespace Elcodi\CartCouponBundle\Event\Abstracts;

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
}
