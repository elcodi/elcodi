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
use Elcodi\Component\CartCoupon\Applicator\CartCouponApplicatorCollector;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 * Class CartCouponPricesLoader.
 *
 * API methods:
 *
 * * refreshCouponAmount(CartInterface)
 * * getCouponAbsolutePrice(CartInterface, CouponInterface)
 *
 * @api
 */
class CartCouponPricesLoader
{
    /**
     * @var CartCouponManager
     *
     * CartCouponManager
     */
    private $cartCouponManager;

    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    private $currencyWrapper;

    /**
     * @var CartCouponApplicatorCollector
     *
     * Cart Coupon applicator
     */
    private $cartCouponApplicatorCollector;

    /**
     * Construct method.
     *
     * @param CartCouponManager             $cartCouponManager             Cart coupon manager
     * @param CurrencyWrapper               $currencyWrapper               Currency wrapper
     * @param CartCouponApplicatorCollector $cartCouponApplicatorCollector Cart Coupon applicator
     */
    public function __construct(
        CartCouponManager $cartCouponManager,
        CurrencyWrapper $currencyWrapper,
        CartCouponApplicatorCollector $cartCouponApplicatorCollector
    ) {
        $this->cartCouponManager = $cartCouponManager;
        $this->currencyWrapper = $currencyWrapper;
        $this->cartCouponApplicatorCollector = $cartCouponApplicatorCollector;
    }

    /**
     * Calculates coupons price given actual Cart.
     *
     * @param CartInterface $cart Cart
     */
    public function refreshCouponAmount(CartInterface $cart)
    {
        $couponAmount = Money::create(
            0,
            $this
                ->currencyWrapper
                ->get()
        );

        $coupons = $this
            ->cartCouponManager
            ->getCoupons($cart);

        foreach ($coupons as $coupon) {
            $currentCouponAmount = $this
                ->getCouponAbsolutePrice(
                    $cart,
                    $coupon
                );
            $coupon->setAbsolutePrice($currentCouponAmount);
            $couponAmount = $couponAmount->add($currentCouponAmount);
        }

        $cart->setCouponAmount($couponAmount);
    }

    /**
     * Given a cart and a coupon, returns the real value of the coupon.
     * If the type of the coupon is not valid, then an empty Money instance will
     * be returned, with value 0.
     *
     * @deprecated since version 1.1.0, to be removed in 2.0.0. Use
     *             CartCouponApplicatorCollector::getCouponAbsoluteValue
     *             instead.
     *
     * @param CartInterface   $cart   Abstract Cart object
     * @param CouponInterface $coupon Coupon
     *
     * @return MoneyInterface Coupon price
     */
    public function getCouponAbsolutePrice(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        return $this
            ->cartCouponApplicatorCollector
            ->getCouponAbsoluteValue(
                $cart,
                $coupon
            );
    }
}
