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

use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;
use Elcodi\Component\CartCoupon\Transformer\CartCouponToOrderCouponTransformer;

/**
 * Class ConvertCartCouponsToOrderCouponsEventListener.
 */
final class ConvertCartCouponsToOrderCouponsEventListener
{
    /**
     * @var CartCouponToOrderCouponTransformer
     *
     * CartCoupon to OrderCoupon transformer
     */
    private $cartCouponToOrderTransformer;

    /**
     * construct method.
     *
     * @param CartCouponToOrderCouponTransformer $cartCouponToOrderTransformer CartCoupon to OrderCoupon transformer
     */
    public function __construct(CartCouponToOrderCouponTransformer $cartCouponToOrderTransformer)
    {
        $this->cartCouponToOrderTransformer = $cartCouponToOrderTransformer;
    }

    /**
     * A new Order has been created.
     *
     * @param OrderOnCreatedEvent $event OrderOnCreated Event
     */
    public function createOrderCouponsByCartCoupons(OrderOnCreatedEvent $event)
    {
        $this
            ->cartCouponToOrderTransformer
            ->createOrderCouponsByCartCoupons(
                $event->getCart(),
                $event->getOrder()
            );
    }
}
