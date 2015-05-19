<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Exception\CouponAlreadyAppliedException;
use Elcodi\Component\CartCoupon\Repository\CartCouponRepository;

/**
 * Class AvoidDuplicatesEventListener
 */
class AvoidDuplicatesEventListener
{
    /**
     * @var CartCouponRepository
     *
     * CartCoupon Repository
     */
    protected $cartCouponRepository;

    /**
     * Construct method
     *
     * @param CartCouponRepository $cartCouponRepository Repository where to find cartcoupons
     */
    public function __construct(CartCouponRepository $cartCouponRepository)
    {
        $this->cartCouponRepository = $cartCouponRepository;
    }

    /**
     * Check if this coupon is already applied to the cart
     *
     * @param CartCouponOnApplyEvent $event Event
     *
     * @throws CouponAlreadyAppliedException
     */
    public function checkDuplicates(CartCouponOnApplyEvent $event)
    {
        $cartCoupon = $this
            ->cartCouponRepository
            ->findOneBy([
                'cart' => $event->getCart(),
                'coupon' => $event->getCoupon(),
            ]);

        if (null !== $cartCoupon) {
            throw new CouponAlreadyAppliedException();
        }
    }
}
