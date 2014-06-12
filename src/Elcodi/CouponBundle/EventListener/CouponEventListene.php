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

namespace Elcodi\CouponBundle\EventListener;

use Elcodi\CouponBundle\Event\CouponUsedEvent;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CouponEventListener
 */
class CouponEventListene
{
    /**
     * @var ObjectManager
     *
     * Coupon ObjectManager
     */
    protected $couponObjectManager;

    /**
     * Construct method
     *
     * @param ObjectManager $couponObjectManager Coupon Object Manager
     */
    public function __construct(
        ObjectManager $couponObjectManager
    )
    {
        $this->couponObjectManager = $couponObjectManager;
    }

    /**
     * This subscriber check if coupon can be still used by checking if number
     * of coupons is already smaller than times it has been used.
     *
     * If not, disables it.
     *
     * @param CouponUsedEvent $event Event
     */
    public function onCouponUsedEvent(CouponUsedEvent $event)
    {
        $coupon = $event->getCoupon();
        $count = $coupon->getCount();
        $used = $coupon->getUsed();

        $used++;
        $coupon->setUsed($used);

        if ($count <= $used) {

            $coupon->setEnabled(false);
        }

        $this->couponObjectManager->flush($coupon);
    }
}
