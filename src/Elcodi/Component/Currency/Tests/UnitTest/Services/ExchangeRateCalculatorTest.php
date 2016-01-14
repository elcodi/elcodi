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
use Elcodi\Component\Currency\Services\ExchangeRateCalculator;

/**
 * Class ExchangeRateCalculatorTest.
 *
 * @author Roger Gros <roger@gros.cat>
 */
class ExchangeRateCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     *
     * The currency ISO that we are using as default exchange rate ISO.
     */
    const DEFAULT_EXCHANGE_CURRENCY_ISO = 'USD';

    /**
     * @var ExchangeRateCalculator
     *
     * The object being tested.
     */
    protected static $exchangeRateCalculator;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $currencyManagerMock = $this
            ->getMockBuilder('Elcodi\Component\Currency\Services\CurrencyManager')
            ->disableOriginalConstructor()
            ->setMethods(['getExchangeRateList'])
            ->getMock();

        $currencyManagerMock
            ->method('getExchangeRateList')
            ->willReturn(self::getMockResponseExchangeRateList());

        self::$exchangeRateCalculator = new ExchangeRateCalculator(
            $currencyManagerMock,
            self::DEFAULT_EXCHANGE_CURRENCY_ISO
        );
    }

    /**
     * Data provider for testCorrectConversions test.
     *
     * @return array
     */
    public function correctConversionsProvider()
    {
        return [
            'Exchange to the same currency' => [
                'EUR',
                'EUR',
                1.0000000000,
            ],
            'Exchange to default currency' => [
                'EUR',
                'USD',
                1.0933000387,
            ],
            'Exchange from default currency' => [
                'USD',
                'EUR',
                0.9146620000,
            ],
            'Exchange between non default currencies' => [
                'JPY',
                'MXN',
                0.1309237083,
            ],
        ];
    }

    /**
     * Tests all the possible conversion methods.
     *
     * @param string $convertFromIso       The ISO we are converting from.
     * @param string $convertToIso         The ISO we are converting to.
     * @param float  $expectedExchangeRate The expectex exchange rate.
     *
     * @dataProvider correctConversionsProvider
     */
    public function testCorrectConversions(
        $convertFromIso,
        $convertToIso,
        $expectedExchangeRate
    ) {
        $currencyFrom = $this->createCurrency($convertFromIso);
        $currencyTo = $this->createCurrency($convertToIso);

        $exchangeRate = self::$exchangeRateCalculator->calculateExchangeRate(
            $currencyFrom,
            $currencyTo
        );

        $this->assertSameExchangeRates(
            $expectedExchangeRate,
            $exchangeRate,
            "Unexpected change rate calculated from $convertFromIso to $convertToIso"
        );
    }

    /**
     * The data provider for testNonPresentCurrencyConversions.
     *
     * @return array
     */
    public function nonExistentCurrencyConversionsProvider()
    {
        return [
            'Converting from a non existent currency' => [
                'ERR',
                'USD',
            ],
            'Converting to a non existent currency' => [
                'USD',
                'ERR',
            ],
            'Converting from and to non existent currencies' => [
                'ER1',
                'ER2',
            ],
        ];
    }

    /**
     * Tests the exchange cases when the we receive an invalid currency.
     *
     * @param string $convertFromIso The ISO we are converting from.
     * @param string $convertToIso   The ISO we are converting to.
     *
     * @dataProvider nonExistentCurrencyConversionsProvider
     */
    public function testNonPresentCurrencyConversions(
        $convertFromIso,
        $convertToIso
    ) {
        $currencyFrom = $this->createCurrency($convertFromIso);
        $currencyTo = $this->createCurrency($convertToIso);

        $exception = 'Elcodi\Component\Currency\Exception\CurrencyNotConvertibleException';
        $this->setExpectedException($exception);

        self::$exchangeRateCalculator->calculateExchangeRate(
            $currencyFrom,
            $currencyTo
        );
    }

    /**
     * Get the mock response exchange rate list.
     *
     * @return array
     */
    protected function getMockResponseExchangeRateList()
    {
        return [
            'EUR' => [
                'rate' => 0.9146620000,
                'currency' => $this->createCurrency('EUR'),
            ],
            'JPY' => [
                'rate' => 124.6600040000,
                'currency' => $this->createCurrency('JPY'),
            ],
            'MXN' => [
                'rate' => 16.3209500000,
                'currency' => $this->createCurrency('MXN'),
            ],
        ];
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

    /**
     * Assert that both exchange rates are the same.
     *
     * @param float  $expected
     * @param float  $actual
     * @param string $message
     */
    protected function assertSameExchangeRates($expected, $actual, $message)
    {
        $expected = number_format($expected, 10);
        $actual = number_format($actual, 10);

        $this->assertEquals(
            $expected,
            $actual,
            $message
        );
    }
}
