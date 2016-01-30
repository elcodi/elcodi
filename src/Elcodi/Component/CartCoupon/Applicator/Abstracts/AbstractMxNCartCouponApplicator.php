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

namespace Elcodi\Component\CartCoupon\Applicator\Abstracts;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Applicator\ExpressionLanguage\ExpressionLanguageFunctionCollector;
use Elcodi\Component\CartCoupon\Applicator\Interfaces\CartCouponApplicatorInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;
use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class AbstractMxNCartCouponApplicator.
 */
abstract class AbstractMxNCartCouponApplicator implements CartCouponApplicatorInterface
{
    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    protected $currencyWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    protected $currencyConverter;

    /**
     * @var ExpressionLanguageFunctionCollector
     *
     * ExpressionLanguageFunction collector
     */
    protected $expressionLanguageFunctionCollector;

    /**
     * Construct method.
     *
     * @param CurrencyWrapper                     $currencyWrapper                     Currency wrapper
     * @param CurrencyConverter                   $currencyConverter                   Currency converter
     * @param ExpressionLanguageFunctionCollector $expressionLanguageFunctionCollector ExpressionLanguageFunction collector
     */
    public function __construct(
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter,
        ExpressionLanguageFunctionCollector $expressionLanguageFunctionCollector
    ) {
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
        $this->expressionLanguageFunctionCollector = $expressionLanguageFunctionCollector;
    }

    /**
     * Get the id of the Applicator.
     *
     * @return string Applicator id
     */
    public static function id()
    {
        return 3;
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
        return
            $coupon->getType() === self::id() &&
            1 === preg_match($this->regexp(), $coupon->getValue());
    }

    /**
     * Get the regular expression.
     *
     * @return string Regular Expression
     */
    abstract public function regexp();

    /**
     * Get expression language instance.
     *
     * @return ExpressionLanguage
     */
    protected function getExpressionLanguageInstance()
    {
        $expressionLanguage = new ExpressionLanguage();

        $this
            ->expressionLanguageFunctionCollector
            ->registerFunction($expressionLanguage);

        return $expressionLanguage;
    }

    /**
     * Evaluate purchasables.
     */
    protected function evaluatePurchasableType(
        PurchasableInterface $purchasable,
        $modifiers
    ) {
        if (empty($modifiers)) {
            return true;
        }

        if (
            false === strpos($modifiers, 'P') &&
            false === strpos($modifiers, 'V') &&
            false === strpos($modifiers, 'K')
        ) {
            return true;
        }

        if (
            $purchasable instanceof ProductInterface &&
            false !== strpos($modifiers, 'P')
        ) {
            return true;
        }

        if (
            $purchasable instanceof VariantInterface &&
            false !== strpos($modifiers, 'V')
        ) {
            return true;
        }

        if (
            $purchasable instanceof PackInterface &&
            false !== strpos($modifiers, 'K')
        ) {
            return true;
        }

        return false;
    }
}
