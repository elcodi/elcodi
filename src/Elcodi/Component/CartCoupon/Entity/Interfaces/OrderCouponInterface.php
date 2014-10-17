<?php

/*
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

namespace Elcodi\Component\CartCoupon\Entity\Interfaces;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Class OrderCouponInterface
 */
interface OrderCouponInterface
{
    /**
     * Sets Order
     *
     * @param OrderInterface $order Order
     *
     * @return OrderCouponInterface Self object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get Order
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * Sets Coupon
     *
     * @param CouponInterface $coupon Coupon
     *
     * @return OrderCouponInterface Self object
     */
    public function setCoupon(CouponInterface $coupon);

    /**
     * Get Coupon
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon();

    /**
     * Set code
     *
     * @param string $code Code
     *
     * @return $this self Object
     */
    public function setCode($code);

    /**
     * Get code
     *
     * @return string Code
     */
    public function getCode();

    /**
     * Set name coupon name
     *
     * @param string $name
     *
     * @return $this self Object
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set amount
     *
     * @param MoneyInterface $amount Price
     *
     * @return $this self Object
     */
    public function setAmount(MoneyInterface $amount);

    /**
     * Get amount
     *
     * @return MoneyInterface Price
     */
    public function getAmount();
}
