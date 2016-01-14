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

namespace Elcodi\Component\CartCoupon\EventDispatcher;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\ElcodiCartCouponEvents;
use Elcodi\Component\CartCoupon\Event\OrderCouponOnApplyEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class OrderCouponEventDispatcher.
 */
class OrderCouponEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch event just before a coupon is applied into an Order.
     *
     * @param OrderInterface  $cart   Cart where to apply the coupon
     * @param CouponInterface $coupon Coupon to be applied
     *
     * @return $this Self object
     */
    public function dispatchOrderCouponOnApplyEvent(
        OrderInterface $cart,
        CouponInterface $coupon
    ) {
        $event = new OrderCouponOnApplyEvent(
            $cart,
            $coupon
        );

        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::ORDER_COUPON_ONAPPLY,
            $event
        );
    }
}
