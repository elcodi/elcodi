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

namespace Elcodi\CartCouponBundle\EventDispatcher;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartCouponBundle\ElcodiCartCouponEvents;
use Elcodi\CartCouponBundle\Event\OrderCouponOnApplyEvent;
use Elcodi\CoreBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;

/**
 * Class CartOrderEventDIspatcher
 */
class OrderCouponEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch event just before a coupon is applied into an Order
     *
     * @param OrderInterface  $cart   Cart where to apply the coupon
     * @param CouponInterface $coupon Coupon to be applied
     *
     * @return CartCouponEventDispatcher self Object
     */
    public function dispatchOrderCouponOnApplyEvent(
        OrderInterface $cart,
        CouponInterface $coupon
    )
    {
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
