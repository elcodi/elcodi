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

use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Exception\CouponNotStackableException;
use Elcodi\Component\CartCoupon\Repository\CartCouponRepository;

/**
 * Class StackableCouponEventListener
 */
class StackableCouponEventListener
{
    /**
     * @var CartCouponRepository
     *
     * CartCoupon Repository
     */
    private $cartCouponRepository;

    /**
     * Construct method
     *
     * @param CartCouponRepository $cartCouponRepository Repository where to
     *                                                   find cartcoupons
     */
    public function __construct(CartCouponRepository $cartCouponRepository)
    {
        $this->cartCouponRepository = $cartCouponRepository;
    }

    /**
     * Check if this coupon can be applied when other coupons had previously
     * been applied
     *
     * @param CartCouponOnApplyEvent $event Event
     *
     * @return null
     *
     * @throws CouponNotStackableException
     */
    public function checkStackableCoupon(CartCouponOnApplyEvent $event)
    {
        $cartCoupons = $this
            ->cartCouponRepository
            ->findBy([
                'cart' => $event->getCart(),
            ]);

        /**
         * If there are no previously applied coupons we can skip the check
         */
        if (0 == count($cartCoupons)) {
            return null;
        }

        $coupon = $event->getCoupon();

        $appliedCouponsCanBeStacked = array_reduce(
            $cartCoupons,
            function ($previousCouponsAreStackable, CartCouponInterface $cartCoupon) {

                return
                    $previousCouponsAreStackable &&
                    $cartCoupon
                        ->getCoupon()
                        ->getStackable();
            },
            true
        );

        /**
         * Checked coupon can be stackable and everithing that was
         * previously applied is also stackable
         */
        if ($coupon->getStackable() && $appliedCouponsCanBeStacked) {
            return null;
        }

        throw new CouponNotStackableException();
    }
}
