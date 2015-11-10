<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\CartCoupon\Event;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Interface OrderCouponOnApplyEventInterface
 */
interface OrderCouponOnApplyEventInterface
{
    /**
     * Set OrderCoupon
     *
     * @param OrderCouponInterface $orderCoupon OrderCoupon
     *
     * @return $this Self object
     */
    public function setOrderCoupon(OrderCouponInterface $orderCoupon);

    /**
     * Return order
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * Return Coupon
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon();

    /**
     * Get OrderCoupon
     *
     * @return OrderCouponInterface OrderCoupon
     */
    public function getOrderCoupon();
}
