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

namespace Elcodi\Component\CartCoupon\Applicator;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Applicator\Interfaces\CartCouponApplicatorInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 * Class CartCouponApplicatorCollector.
 */
class CartCouponApplicatorCollector
{
    /**
     * @var CartCouponApplicatorInterface[]
     *
     * Cart Coupon Applicators
     */
    private $cartCouponApplicators = [];

    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    private $currencyWrapper;

    /**
     * Construct method.
     *
     * @param CurrencyWrapper $currencyWrapper Currency wrapper
     */
    public function __construct(CurrencyWrapper $currencyWrapper)
    {
        $this->currencyWrapper = $currencyWrapper;
    }

    /**
     * Add Cart Coupon Applicator.
     *
     * @param CartCouponApplicatorInterface $cartCouponApplicator Cart Coupon Applicator
     */
    public function addCartCouponApplicator(CartCouponApplicatorInterface $cartCouponApplicator)
    {
        $this->cartCouponApplicators[] = $cartCouponApplicator;
    }

    /**
     * Calculate coupon absolute value.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return MoneyInterface Absolute value for this coupon in this cart
     */
    public function getCouponAbsoluteValue(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $currency = $this
            ->currencyWrapper
            ->get();

        $couponPrice = Money::create(
            0,
            $currency
        );

        foreach ($this->cartCouponApplicators as $cartCouponApplicator) {
            if ($cartCouponApplicator->canBeApplied(
                $cart,
                $coupon
            )) {
                return $cartCouponApplicator->getCouponAbsoluteValue(
                    $cart,
                    $coupon
                );
            }
        }

        return $couponPrice;
    }
}
