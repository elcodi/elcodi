<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\CartCoupon\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\CartCoupon\Exception\CouponNotStackableException;
use Elcodi\Component\CartCoupon\Repository\CartCouponRepository;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class StackableCouponChecker
 */
class StackableCouponChecker
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
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return null
     *
     * @throws CouponNotStackableException Coupon is not stackable
     */
    public function checkStackableCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $cartCoupons = $this
            ->cartCouponRepository
            ->findBy([
                'cart' => $cart,
            ]);

        /**
         * If there are no previously applied coupons we can skip the check
         */
        if (0 == count($cartCoupons)) {
            return;
        }

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
         * Checked coupon can be stackable and everything that was
         * previously applied is also stackable
         */
        if ($coupon->getStackable() && $appliedCouponsCanBeStacked) {
            return null;
        }

        throw new CouponNotStackableException();
    }
}
