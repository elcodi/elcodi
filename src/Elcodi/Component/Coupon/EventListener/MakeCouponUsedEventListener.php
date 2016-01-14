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

namespace Elcodi\Component\Coupon\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Coupon\Event\CouponOnUsedEvent;

/**
 * Class MakeCouponUsedEventListener.
 */
class MakeCouponUsedEventListener
{
    /**
     * @var ObjectManager
     *
     * Coupon ObjectManager
     */
    private $couponObjectManager;

    /**
     * Construct method.
     *
     * @param ObjectManager $couponObjectManager Coupon Object Manager
     */
    public function __construct(ObjectManager $couponObjectManager)
    {
        $this->couponObjectManager = $couponObjectManager;
    }

    /**
     * This subscriber check if coupon can be still used by checking if number
     * of coupons is already smaller than times it has been used.
     *
     * If not, disables it.
     *
     * @param CouponOnUsedEvent $event Event
     */
    public function makeUse(CouponOnUsedEvent $event)
    {
        $coupon = $event->getCoupon();
        $coupon->makeUse();

        $this
            ->couponObjectManager
            ->flush($coupon);
    }
}
