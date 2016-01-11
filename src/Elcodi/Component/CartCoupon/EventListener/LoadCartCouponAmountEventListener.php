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

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\CartCoupon\Services\CartCouponPricesLoader;

/**
 * Class LoadCartCouponAmountEventListener.
 */
final class LoadCartCouponAmountEventListener
{
    /**
     * @var CartCouponPricesLoader
     *
     * CartCoupon prices loader
     */
    private $cartCouponPricesLoader;

    /**
     * Construct.
     *
     * @param CartCouponPricesLoader $cartCouponPricesLoader CartCoupon prices loader
     */
    public function __construct(CartCouponPricesLoader $cartCouponPricesLoader)
    {
        $this->cartCouponPricesLoader = $cartCouponPricesLoader;
    }

    /**
     * Method subscribed to CartLoad event.
     *
     * Calculates coupons price given actual Cart
     *
     * @param CartOnLoadEvent $event
     */
    public function refreshCouponAmount(CartOnLoadEvent $event)
    {
        $this
            ->cartCouponPricesLoader
            ->refreshCouponAmount(
                $event->getCart()
            );
    }
}
