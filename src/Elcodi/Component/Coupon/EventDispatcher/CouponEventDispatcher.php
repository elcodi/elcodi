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

namespace Elcodi\Component\Coupon\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Coupon\ElcodiCouponEvents;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Event\CouponOnUsedEvent;

/**
 * Class CouponEventDispatcher.
 */
class CouponEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Notify Coupon usage.
     *
     * @param CouponInterface $coupon Coupon used
     *
     * @return $this Self object
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
