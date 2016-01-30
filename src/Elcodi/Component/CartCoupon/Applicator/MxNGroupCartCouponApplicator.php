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
use Elcodi\Component\CartCoupon\Applicator\Abstracts\AbstractMxNCartCouponApplicator;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class MxNGroupCartCouponApplicator.
 */
class MxNGroupCartCouponApplicator extends AbstractMxNCartCouponApplicator
{
    /**
     * Get the regular expression.
     *
     * @return string Regular Expression
     */
    public function regexp()
    {
        return '~^(?:([1-9]\d*)x([1-9]\d*))(?::([^:]*))?(?::((?=.*[G])[A-Z]+))$~';
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

        $couponPrice = Money::create(
            0,
            $currency
        );

        $value = $coupon->getValue();
        preg_match($this->regexp(), $value, $match);
        $m = (int) $match[1];
        $n = (int) $match[2];
        $expressionValue = isset($match[3]) ? $match[3] : '';
        $modifiers = isset($match[4]) ? $match[4] : '';

        $totalElements = 0;
        $moneys = [];
        $freePerGroup = $m - $n;
        $freePerGroup = max($freePerGroup, 0);

        foreach ($cart->getCartLines() as $cartLine) {
            $purchasable = $cartLine->getPurchasable();
            $expressionEvaluator = $this->getExpressionLanguageInstance();
            $expressionResult =
                (
                    empty($expressionValue) ||
                    $expressionEvaluator->evaluate($expressionValue, [
                        'purchasable' => $purchasable,
                    ])
                ) &&
                $this->evaluatePurchasableType($purchasable, $modifiers);

            if (true === $expressionResult) {
                $partialElements = $cartLine->getQuantity();
                $totalElements += $partialElements;
                for ($i = 0; $i < $partialElements; ++$i) {
                    $partialPurchasable = $cartLine->getPurchasable();
                    $moneys[] = $partialPurchasable->getReducedPrice()->getAmount() > 0
                        ? $partialPurchasable->getReducedPrice()
                        : $partialPurchasable->getPrice();
                }
            }
        }

        usort($moneys, function (MoneyInterface $a, MoneyInterface $b) {
            $aCurrency = $a->getCurrency();
            $bPriceInACurrency = $this
                ->currencyConverter
                ->convertMoney(
                    $b,
                    $aCurrency
                );

            return $a->isGreaterThan($bPriceInACurrency)
                ? 1
                : -1;
        });
        $groups = floor($totalElements / $m);
        if ($groups > 0) {
            $nbMoneys = $groups * $freePerGroup;
            $moneysToDiscount = array_slice($moneys, 0, $nbMoneys);

            foreach ($moneysToDiscount as $moneyToDiscount) {
                $couponPrice = $couponPrice->add(
                    $this
                        ->currencyConverter
                        ->convertMoney(
                            $moneyToDiscount,
                            $currency
                        )
                );
            }
        }

        return $couponPrice;
    }
}
