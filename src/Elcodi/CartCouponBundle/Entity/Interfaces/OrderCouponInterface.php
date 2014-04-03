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

namespace Elcodi\CartCouponBundle\Entity\Interfaces;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;

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
}
