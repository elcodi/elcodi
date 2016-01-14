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

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\OrderCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Transformer\CouponToOrderCouponTransformer;

/**
 * Class CreateOrderCouponByCouponEventListener.
 */
final class CreateOrderCouponByCouponEventListener
{
    /**
     * @var CouponToOrderCouponTransformer
     *
     * Coupon to OrderCoupon transformer
     */
    private $couponToOrderCouponTransformer;

    /**
     * construct method.
     *
     * @param CouponToOrderCouponTransformer $couponToOrderCouponTransformer Coupon to OrderCoupon transformer
     */
    public function __construct(CouponToOrderCouponTransformer $couponToOrderCouponTransformer)
    {
        $this->couponToOrderCouponTransformer = $couponToOrderCouponTransformer;
    }

    /**
     * Event subscribed on OrderCoupon applied into an order.
     *
     * Just should create a new OrderCoupon instance, persist and flush it
     *
     * Also notifies to CouponBundle that a simple coupon has been
     * used by an Order.
     *
     * @param OrderCouponOnApplyEvent $event Event
     */
    public function createOrderCouponByCoupon(OrderCouponOnApplyEvent $event)
    {
        $orderCoupon = $this
            ->couponToOrderCouponTransformer
            ->createOrderCouponByCoupon(
                $event->getOrder(),
                $event->getCoupon()
            );

        $event->setOrderCoupon($orderCoupon);
    }
}
