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

use Doctrine\Common\Persistence\ObjectRepository;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;

/**
 * Class AutomaticCouponApplicator.
 *
 * API methods:
 *
 * * tryAutomaticCoupons(CartInterface)
 *
 * @api
 */
class AutomaticCouponApplicator
{
    /**
     * @var CartCouponManager
     *
     * Coupon manager
     */
    private $cartCouponManager;

    /**
     * @var ObjectRepository
     *
     * Coupon Repository
     */
    private $couponRepository;

    /**
     * Construct method.
     *
     * @param CartCouponManager $cartCouponManager Manager for cart coupon rules
     * @param ObjectRepository  $couponRepository  Repository to get coupons
     */
    public function __construct(
        CartCouponManager $cartCouponManager,
        ObjectRepository $couponRepository
    ) {
        $this->cartCouponManager = $cartCouponManager;
        $this->couponRepository = $couponRepository;
    }

    /**
     * Method subscribed to PreCartLoad event.
     *
     * Iterate over all automatic Coupons and check if they apply.
     * If any applies, it will be added to the Cart
     *
     * @param CartInterface $cart Cart
     */
    public function tryAutomaticCoupons(CartInterface $cart)
    {
        if ($cart->getCartLines()->isEmpty()) {
            return;
        }

        $automaticCoupons = $this->getNonAppliedAutomaticCoupons($cart);

        foreach ($automaticCoupons as $coupon) {
            try {
                $this
                    ->cartCouponManager
                    ->addCoupon($cart, $coupon);
            } catch (AbstractCouponException $e) {
                // Silently tries next coupon on controlled exception
            }
        }
    }

    /**
     * Get current cart automatic coupons.
     *
     * @param CartInterface $cart Cart
     *
     * @returns CouponInterface[] Array of non applied coupons
     */
    private function getNonAppliedAutomaticCoupons(CartInterface $cart)
    {
        $automaticCoupons = $this
            ->couponRepository
            ->findBy([
                'enforcement' => ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC,
            ]);

        $loadedAutomaticCoupons = $this
            ->cartCouponManager
            ->getCoupons($cart);

        return array_udiff(
            $automaticCoupons,
            $loadedAutomaticCoupons,
            function (CouponInterface $a, CouponInterface $b) {
                return $a->getId() != $b->getId();
            }
        );
    }
}
