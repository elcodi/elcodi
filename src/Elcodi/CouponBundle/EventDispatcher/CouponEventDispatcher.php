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

namespace Elcodi\CouponBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\Event\CouponOnUsedEvent;
use Elcodi\CouponBundle\ElcodiCouponEvents;

/**
 * Class CouponEventDispatcher
 */
class CouponEventDispatcher
{
    /**
     * @var EventDispatcherInterface
     *
     * Event dispatcher
     */
    protected $eventDispatcher;

    /**
     * Construct method
     *
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Notify Coupon usage
     *
     * @param CouponInterface $coupon Coupon used
     *
     * @return CouponEventDispatcher self Object
     */
    public function notifyCouponUsage(CouponInterface $coupon)
    {
        $couponUsedEvent = new CouponOnUsedEvent($coupon);

        $this->eventDispatcher->dispatch(
            ElcodiCouponEvents::COUPON_USED,
            $couponUsedEvent
        );

        return $this;
    }
}
