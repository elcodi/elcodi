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

namespace Elcodi\Component\Currency\Tests\UnitTest\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Currency\Entity\Currency;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;

/**
 * Class CurrencyConverterTest.
 */
class CurrencyConverterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CurrencyConverter
     */
    private $currencyConverter;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $exchangeCalculatorMock = $this
            ->getMockBuilder('Elcodi\Component\Currency\Services\ExchangeRateCalculator')
            ->disableOriginalConstructor()
            ->setMethods(['calculateExchangeRate'])
            ->getMock();

        $exchangeCalculatorMock
            ->method('calculateExchangeRate')
            ->willReturn(0.5000000000);

        $this->currencyConverter = new CurrencyConverter(
            $exchangeCalculatorMock
        );
    }

    /**
     * data for testConvertMoney.
     */
    public function dataConvertMoney()
    {
        return [
            'Exchange from the same currency' => [
                'USD',
                'USD',
                100,
                100,
            ],
            'Exchange from the same currency with no amount' => [
                'USD',
                'USD',
                0,
                0,
            ],
            'Exchange from different currencies' => [
                'USD',
                'EUR',
                1000000,
                500000,
            ],
            'Exchange from different currencies with no amount' => [
                'EUR',
                'USD',
                0,
                0,
            ],
        ];
    }

    /**
     * Test convert money.
     *
     * @param $isoFrom
     * @param $isoTo
     * @param $amount
     * @param $resultAmount
     *
     * @dataProvider dataConvertMoney
     */
    public function testConvertMoney(
        $isoFrom,
        $isoTo,
        $amount,
        $resultAmount
    ) {
        $currencyFrom = $this->createCurrency($isoFrom);
        $currencyTo = $this->createCurrency($isoTo);
        $money = Money::create($amount, $currencyFrom);

        $moneyResult = $this
            ->currencyConverter
            ->convertMoney($money, $currencyTo);

        $this->assertEquals($moneyResult->getAmount(), $resultAmount);
        $this->assertEquals($moneyResult->getCurrency(), $currencyTo);
    }

    /**
     * Creates a currency.
     *
     * @param string $iso The currency ISO.
     *
     * @return CurrencyInterface
     */
    protected function createCurrency($iso)
    {
        $currency = new Currency();
        $currency
            ->setIso($iso);

        return $currency;
    }
}
