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

use Elcodi\Component\CartCoupon\Event\CartCouponOnRemoveEvent;
use Elcodi\Component\CartCoupon\Services\CartCouponManager;

/**
 * Class RemoveCartCouponEventListener.
 */
final class RemoveCartCouponEventListener
{
    /**
     * @var CartCouponManager
     *
     * CartCoupon manager
     */
    private $cartCouponManager;

    /**
     * Construct method.
     *
     * @param CartCouponManager $cartCouponManager CartCoupon manager
     */
    public function __construct(CartCouponManager $cartCouponManager)
    {
        $this->cartCouponManager = $cartCouponManager;
    }

    /**
     * Removes Coupon from Cart, and flushes it.
     *
     * @param CartCouponOnRemoveEvent $event Event
     */
    public function removeCartCoupon(CartCouponOnRemoveEvent $event)
    {
        $this
            ->cartCouponManager
            ->removeCartCoupon(
                $event->getCartCoupon()
            );
    }
}
