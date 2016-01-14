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
use Elcodi\Component\CartCoupon\Services\AutomaticCouponApplicator;

/**
 * Class TryAutomaticCouponsApplicationEventListener.
 */
final class TryAutomaticCouponsApplicationEventListener
{
    /**
     * @var AutomaticCouponApplicator
     *
     * Automatic coupon applicator
     */
    private $automaticCouponApplicator;

    /**
     * Construct method.
     *
     * @param AutomaticCouponApplicator $automaticCouponApplicator Automatic coupon applicator
     */
    public function __construct(AutomaticCouponApplicator $automaticCouponApplicator)
    {
        $this->automaticCouponApplicator = $automaticCouponApplicator;
    }

    /**
     * Method subscribed to PreCartLoad event.
     *
     * Iterate over all automatic Coupons and check if they apply.
     * If any applies, it will be added to the Cart
     *
     * @param CartOnLoadEvent $event Event
     */
    public function tryAutomaticCoupons(CartOnLoadEvent $event)
    {
        $this
            ->automaticCouponApplicator
            ->tryAutomaticCoupons(
                $event->getCart()
            );
    }
}
