<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartCouponBundle\Entity\Interfaces\OrderCouponInterface;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;

/**
 * Class OrderCouponOnApplyEvent
 */
class OrderCouponOnApplyEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var CouponInterface
     *
     * Coupon
     */
    protected $coupon;

    /**
     * @var OrderCouponInterface
     *
     * OrderCoupon
     */
    protected $orderCoupon;

    /**
     * Construct method
     *
     * @param OrderInterface  $order  Order
     * @param CouponInterface $coupon Coupon
     */
    public function __construct(
        OrderInterface $order,
        CouponInterface $coupon
    )
    {
        $this->order = $order;
        $this->coupon = $coupon;
    }

    /**
     * Set OrderCoupon
     *
     * @param OrderCouponInterface $orderCoupon OrderCoupon
     *
     * @return OrderCouponOnApplyEvent self Object
     */
    public function setOrderCoupon(OrderCouponInterface $orderCoupon)
    {
        $this->orderCoupon = $orderCoupon;

        return $this;
    }

    /**
     * Return order
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
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
     * Get OrderCoupon
     *
     * @return OrderCouponInterface OrderCoupon
     */
    public function getOrderCoupon()
    {
        return $this->orderCoupon;
    }
}
