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
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
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
     * @var CurrencyConverter
     *
     * Currency converter
     */
    private $currencyConverter;

    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    private $currencyWrapper;

    /**
     * Construct method.
     *
     * @param CartCouponManager $cartCouponManager Cart coupon manager
     * @param CurrencyWrapper   $currencyWrapper   Currency wrapper
     * @param CurrencyConverter $currencyConverter Currency converter
     */
    public function __construct(
        CartCouponManager $cartCouponManager,
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter
    ) {
        $this->cartCouponManager = $cartCouponManager;
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
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
     * @param CartInterface   $cart   Abstract Cart object
     * @param CouponInterface $coupon Coupon
     *
     * @return MoneyInterface Coupon price
     */
    public function getCouponAbsolutePrice(
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

        switch ($coupon->getType()) {

            case ElcodiCouponTypes::TYPE_PERCENT:

                $couponPercent = $coupon->getDiscount();

                $couponPrice = $cart
                    ->getPurchasableAmount()
                    ->multiply($couponPercent / 100);
                break;

            case ElcodiCouponTypes::TYPE_AMOUNT:

                $amount = $coupon->getPrice();

                $couponPrice = $this
                    ->currencyConverter
                    ->convertMoney(
                        $amount,
                        $currency
                    );
                break;
        }

        return $couponPrice;
    }
}
