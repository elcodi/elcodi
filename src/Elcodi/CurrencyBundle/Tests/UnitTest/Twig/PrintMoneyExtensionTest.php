<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CurrencyBundle\Tests\UnitTest\Twig;

use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Twig\PrintMoneyExtension;

/**
 * Class PrintMoneyExtensionTest
 */
class PrintMoneyExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     *
     * Sample currency exchange rates
     */
    protected $baseCurrencyExchangeRates = [
        'EUR' => [
            'EUR' => 1.0, 'USD' => 1.33, 'GBP' => 0.8
        ]
    ];

    /**
     * @var array
     *
     * Sample currency symbols
     */
    protected $baseCurrencySymbols = [
        'EUR' => '€', 'USD' => '$', 'GBP' => '£'
    ];

    /**
     * Money Stub needed for testing PrintMoneyExtension
     *
     * @var Money
     */
    protected $money;

    public function setUp()
    {
        // Amounts are in cents!
        $amount = 1000000;

        $currencyMockEUR = $this->getMock(
            'Elcodi\CurrencyBundle\Entity\Currency',
            ['getIso']
        );
        $currencyMockEUR
            ->expects($this->any())
            ->method('getIso')
            ->will($this->returnValue('EUR'));

        $this->money = new Money($amount, $currencyMockEUR);
    }

    /**
     * Test price output
     */
    public function testPrintPrice()
    {
        $money = $this->money;

        $priceExtension = new PrintMoneyExtension(
            $this->baseCurrencyExchangeRates,
            $this->baseCurrencySymbols,
            'es_ES'
        );

        $this->assertEquals(
            '13.300,00 $',
            $priceExtension->printMoney($money, 'USD'),
            'Price format does not match - EUR USD'
        );

        $this->assertEquals(
            '8.000,00 £',
            $priceExtension->printMoney($money, 'GBP'),
            'Price format does not match - EUR GBP'
        );

        $priceExtension = new PrintMoneyExtension(
            $this->baseCurrencyExchangeRates,
            $this->baseCurrencySymbols,
            'en_GB'
        );

        $this->assertEquals(
            '$13,300.00',
            $priceExtension->printMoney($money, 'USD'),
            'Price format does not match - EUR USD'
        );

        $this->assertEquals(
            '£8,000.00',
            $priceExtension->printMoney($money, 'GBP'),
            'Price format does not match - EUR GBP'
        );

    }

    /**
     * @expectedException \Exception
     */
    public function testCurrencyRateNotFoundThrowsException()
    {
        $priceExtension = new PrintMoneyExtension(
            $this->baseCurrencyExchangeRates,
            $this->baseCurrencySymbols,
            'es_ES'
        );

        $this->assertEquals(
            '13 300,00 $',
            $priceExtension->printMoney($this->money, 'US1'),
            'Price format does not match - EUR USD'
        );

    }
}
