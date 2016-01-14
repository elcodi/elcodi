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

namespace Elcodi\Component\CartCoupon\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Exception\CouponAlreadyAppliedException;
use Elcodi\Component\CartCoupon\Repository\CartCouponRepository;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class DuplicatedCouponValidator.
 *
 * API methods:
 *
 * * validateDuplicatedCoupon(CartInterface, CouponInterface)
 *
 * @api
 */
class DuplicatedCouponValidator
{
    /**
     * @var CartCouponRepository
     *
     * CartCoupon Repository
     */
    private $cartCouponRepository;

    /**
     * Construct method.
     *
     * @param CartCouponRepository $cartCouponRepository Repository where to find cart coupons
     */
    public function __construct(CartCouponRepository $cartCouponRepository)
    {
        $this->cartCouponRepository = $cartCouponRepository;
    }

    /**
     * Check if this coupon is already applied to the cart.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @throws CouponAlreadyAppliedException Coupon already applied
     */
    public function validateDuplicatedCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $cartCoupon = $this
            ->cartCouponRepository
            ->findOneBy([
                'cart' => $cart,
                'coupon' => $coupon,
            ]);

        if (null !== $cartCoupon) {
            throw new CouponAlreadyAppliedException();
        }
    }
}
