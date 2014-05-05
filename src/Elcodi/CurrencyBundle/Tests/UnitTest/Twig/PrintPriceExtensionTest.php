<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CurrencyBundle\Provider;

use Elcodi\CurrencyBundle\Twig\PrintPriceExtension;

/**
 * Class PrintPriceExtensionTest
 */
class PrintPriceExtensionTest extends \PHPUnit_Framework_TestCase
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
     * Test price output
     */
    public function testPrintPrice()
    {
        $priceExtension = new PrintPriceExtension(
            $this->baseCurrencyExchangeRates,
            $this->baseCurrencySymbols,
            'es_ES'
        );

        $amount = 10000.00;

        $this->assertEquals(
            '13 300,00 $',
            $priceExtension->printPrice($amount, 'EUR', 'USD'),
            'Price format does not match - EUR USD'
        );

        $this->assertEquals(
            '8 000,00 £',
            $priceExtension->printPrice($amount, 'EUR', 'GBP'),
            'Price format does not match - EUR GBP'
        );

        $priceExtension = new PrintPriceExtension(
            $this->baseCurrencyExchangeRates,
            $this->baseCurrencySymbols,
            'en_GB'
        );

        $this->assertEquals(
            '$13,300.00',
            $priceExtension->printPrice($amount, 'EUR', 'USD'),
            'Price format does not match - EUR USD'
        );

        $this->assertEquals(
            '£8,000.00',
            $priceExtension->printPrice($amount, 'EUR', 'GBP'),
            'Price format does not match - EUR GBP'
        );
    }
}
