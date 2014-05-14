<?php

/**
 * This file is part of BeEcommerce.
 *
 * @author Befactory Team
 * @since 2013
 */

namespace Elcodi\CouponBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\CouponBundle\ElcodiCouponEvents;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\Event\CouponUsedEvent;

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
    private $eventDispatcher;

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
        $couponUsedEvent = new CouponUsedEvent($coupon);
        $this->eventDispatcher->dispatch(ElcodiCouponEvents::COUPON_USED, $couponUsedEvent);

        return $this;
    }
}
