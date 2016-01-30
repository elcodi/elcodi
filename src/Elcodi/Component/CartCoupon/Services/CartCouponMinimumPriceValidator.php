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
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\CouponBelowMinimumPurchaseException;
use Elcodi\Component\Currency\Services\CurrencyConverter;

/**
 * Class CartCouponMinimumPriceValidator.
 *
 * API methods:
 *
 * * validateCartCouponMinimumPrice(CartInterface, CouponInterface)
 *
 * @api
 */
class CartCouponMinimumPriceValidator
{
    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    private $currencyConverter;

    /**
     * Construct.
     *
     * @param CurrencyConverter $currencyConverter
     */
    public function __construct(CurrencyConverter $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Check if cart meets minimum price requirements for a coupon.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @throws CouponBelowMinimumPurchaseException Minimum value not reached
     */
    public function validateCartCouponMinimumPrice(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $couponMinimumPrice = $coupon->getMinimumPurchase();

        if ($couponMinimumPrice->getAmount() === 0) {
            return;
        }

        $productMoney = $cart->getPurchasableAmount();

        if ($couponMinimumPrice->getCurrency() != $productMoney->getCurrency()) {
            $couponMinimumPrice = $this
                ->currencyConverter
                ->convertMoney(
                    $couponMinimumPrice,
                    $productMoney->getCurrency()
                );
        }

        if ($productMoney->isLessThan($couponMinimumPrice)) {
            throw new CouponBelowMinimumPurchaseException();
        }
    }
}
