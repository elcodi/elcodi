<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\CurrencyBundle\Tests\UnitTest\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Factory\CurrencyFactory;
use Elcodi\CurrencyBundle\Services\CurrencyConverter;
use Elcodi\CurrencyBundle\Services\CurrencyManager;

/**
 * Class CurrencyConverterTest
 */
class CurrencyConverterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test convert money
     *
     * @dataProvider dataConvertMoney
     */
    public function testConvertMoney(
        $isoFrom,
        $isoTo,
        $amount,
        $resultAmount
    )
    {
        $currencyManager = $this
            ->getMockBuilder('Elcodi\CurrencyBundle\Services\CurrencyManager')
            ->setMethods([
                'getExchangeRateList'
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $currencyFactory = new CurrencyFactory();
        $currencyFactory->setEntityNamespace('Elcodi\CurrencyBundle\Entity\Currency');
        $currencyBase = 'USD';

        /**
         * @var CurrencyManager $currencyManager
         */
        $currencyManager
            ->expects($this->any())
            ->method('getExchangeRateList')
            ->will($this->returnValue([
                'EUR' => ['rate' => '0.7365960000', 'currency' => $currencyFactory->create()],
                'GBP' => ['rate' => '0.5887650000', 'currency' => $currencyFactory->create()],
                'JPY' => ['rate' => '101.8226250000', 'currency' => $currencyFactory->create()],
            ]));

        $currencyConverter = new CurrencyConverter(
            $currencyManager,
            $currencyBase
        );

        $currencyFrom = $currencyFactory->create();
        $currencyFrom->setIso($isoFrom);
        $currencyTo = $currencyFactory->create();
        $currencyTo->setIso($isoTo);
        $money = Money::create($amount, $currencyFrom);

        $moneyResult = $currencyConverter->convertMoney($money, $currencyTo);

        $this->assertEquals($moneyResult->getAmount(), $resultAmount);
        $this->assertEquals($moneyResult->getCurrency(), $currencyTo);
    }

    /**
     * data for testConvertMoney
     */
    public function dataConvertMoney()
    {
        return [
            ['USD', 'USD', 100, 100],
            ['USD', 'USD', 0, 0],
            ['USD', 'EUR', 1000000, 736596],
            ['USD', 'EUR', 1000, 736],
            ['EUR', 'EUR', 1000, 1000],
            ['EUR', 'USD', 1000, 1357],
            ['EUR', 'GBP', 1000, 799],
            ['EUR', 'GBP', 0, 0],
            ['GBP', 'EUR', 1000, 1251],
        ];
    }
}
