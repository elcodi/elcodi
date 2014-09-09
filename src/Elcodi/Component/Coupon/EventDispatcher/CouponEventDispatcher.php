<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\Coupon\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Coupon\ElcodiCouponEvents;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Event\CouponOnUsedEvent;

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
     * @return $this self Object
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
