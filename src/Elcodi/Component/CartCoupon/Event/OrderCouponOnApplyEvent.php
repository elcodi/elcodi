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

namespace Elcodi\Component\CartCoupon\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class OrderCouponOnApplyEvent.
 */
final class OrderCouponOnApplyEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    private $order;

    /**
     * @var CouponInterface
     *
     * Coupon
     */
    private $coupon;

    /**
     * @var OrderCouponInterface
     *
     * OrderCoupon
     */
    private $orderCoupon;

    /**
     * Construct method.
     *
     * @param OrderInterface  $order  Order
     * @param CouponInterface $coupon Coupon
     */
    public function __construct(
        OrderInterface $order,
        CouponInterface $coupon
    ) {
        $this->order = $order;
        $this->coupon = $coupon;
    }

    /**
     * Set OrderCoupon.
     *
     * @param OrderCouponInterface $orderCoupon OrderCoupon
     *
     * @return $this Self object
     */
    public function setOrderCoupon(OrderCouponInterface $orderCoupon)
    {
        $this->orderCoupon = $orderCoupon;

        return $this;
    }

    /**
     * Return order.
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
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
     * Get OrderCoupon.
     *
     * @return OrderCouponInterface OrderCoupon
     */
    public function getOrderCoupon()
    {
        return $this->orderCoupon;
    }
}
