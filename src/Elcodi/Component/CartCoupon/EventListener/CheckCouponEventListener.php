<?php

/*
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


namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Coupon\Exception\CouponIncompatibleException;
use Elcodi\Component\Coupon\Services\CouponManager;

/**
 * Class CheckCouponEventListener
 *
 * @author Berny Cantos <be@rny.cc>
 */
class CheckCouponEventListener
{
    /**
     * @var CouponManager
     */
    protected $couponManager;

    /**
     * Constructor
     *
     * @param CouponManager $couponManager
     */
    public function __construct(CouponManager $couponManager)
    {
        $this->couponManager = $couponManager;
    }

    /**
     * Check if cart meets basic requirements for a coupon
     *
     * @param CartCouponOnApplyEvent $event
     *
     * @throws AbstractCouponException
     */
    public function checkCoupon(CartCouponOnApplyEvent $event)
    {
        if ($event->getCart()->getQuantity() === 0) {

            throw new CouponIncompatibleException();
        }

        $coupon = $event->getCoupon();

        $this
            ->couponManager
            ->checkCoupon($coupon);
    }
}
