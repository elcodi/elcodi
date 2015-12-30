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
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 * Class AbsoluteCartCouponApplicator.
 */
class AbsoluteCartCouponApplicator implements CartCouponApplicatorInterface
{
    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    private $currencyWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    private $currencyConverter;

    /**
     * Construct method.
     *
     * @param CurrencyWrapper   $currencyWrapper   Currency wrapper
     * @param CurrencyConverter $currencyConverter Currency converter
     */
    public function __construct(
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter
    ) {
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Get the id of the Applicator.
     *
     * @return string Applicator id
     */
    public static function id()
    {
        return 1;
    }

    /**
     * Can be applied.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return bool Can be applied
     */
    public function canBeApplied(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        return $coupon->getType() === self::id();
    }

    /**
     * Calculate coupon absolute value.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return MoneyInterface|false Absolute value for this coupon in this cart
     */
    public function getCouponAbsoluteValue(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $currency = $this
            ->currencyWrapper
            ->get();

        $amount = $coupon->getPrice();

        return $this
            ->currencyConverter
            ->convertMoney(
                $amount,
                $currency
            );
    }
}
