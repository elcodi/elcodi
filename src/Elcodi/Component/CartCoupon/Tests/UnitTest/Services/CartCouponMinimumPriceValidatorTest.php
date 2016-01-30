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

namespace Elcodi\Component\CartCoupon\Tests\UnitTest\Services;

use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\CartCoupon\Services\CartCouponMinimumPriceValidator;
use Elcodi\Component\Coupon\Exception\CouponBelowMinimumPurchaseException;

/**
 * Class CartCouponMinimumPriceValidatorTest.
 */
class CartCouponMinimumPriceValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test validateCartCouponMinimumPrice.
     *
     * @covers validateCartCouponMinimumPrice
     * @dataProvider dataValidateCartCouponMinimumPrice
     */
    public function testValidateCartCouponMinimumPrice(
        $minimumPurchaseAmount,
        $minimumPurchaseCurrencyCode,
        $productMoneyAmount,
        $productMoneyCurrencyCode,
        $moneyIsConverted,
        $isLess,
        $throwException
    ) {
        $currencyConverter = $this->prophesize('Elcodi\Component\Currency\Services\CurrencyConverter');
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $coupon = $this->prophesize('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $minimumPurchaseCurrency = $this
            ->prophesize('Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface')
            ->reveal();

        $minimumPurchase = $this->prophesize('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface');
        $minimumPurchase
            ->getAmount()
            ->willReturn($minimumPurchaseAmount);

        $minimumPurchase
            ->getCurrency()
            ->willReturn($minimumPurchaseCurrency);

        $productMoneyCurrency = $minimumPurchaseCurrencyCode === $productMoneyCurrencyCode
            ? $minimumPurchaseCurrency
            : $this
                ->prophesize('Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface')
                ->reveal();

        $productMoney = $this->prophesize('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface');
        $productMoney
            ->getAmount()
            ->willReturn($productMoneyAmount);

        $productMoney
            ->getCurrency()
            ->willReturn($productMoneyCurrency);

        $productMoney
            ->isLessThan(Argument::any())
            ->willReturn($isLess);

        $currencyConverterConvertMoney = $currencyConverter
            ->convertMoney(Argument::any(), Argument::any())
            ->willReturn($this
                ->prophesize('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface')
                ->reveal()
            );

        if ($moneyIsConverted) {
            $currencyConverterConvertMoney->shouldBeCalled();
        } else {
            $currencyConverterConvertMoney->shouldNotBeCalled();
        }

        $coupon
            ->getMinimumPurchase()
            ->willReturn($minimumPurchase->reveal());

        $cart
            ->getPurchasableAmount()
            ->willReturn($productMoney->reveal());

        try {
            $cartCouponMinimumPriceValidator = new CartCouponMinimumPriceValidator(
                $currencyConverter->reveal()
            );

            $cartCouponMinimumPriceValidator->validateCartCouponMinimumPrice(
                $cart->reveal(),
                $coupon->reveal()
            );
        } catch (CouponBelowMinimumPurchaseException $e) {
            if (!$throwException) {
                throw $e;
            }
        }
    }

    /**
     * Data for testValidateCartCouponMinimumPrice.
     */
    public function dataValidateCartCouponMinimumPrice()
    {
        return [

            // Minimum price not enough
            [0, 'es', 1, 'en', false, false, false],

            // Equal currencies, no conversion
            [3, 'es', 1, 'es', false, false, false],

            // Different currencies, conversion but not less
            [3, 'es', 1, 'en', true, false, false],

            // Different currencies, conversion and less
            [3, 'es', 1, 'en', true, true, true],

            // Same currencies, not conversion but not less
            [3, 'es', 1, 'es', false, false, false],

            // Same currencies, not conversion and less
            [3, 'es', 1, 'es', false, true, true],
        ];
    }
}
