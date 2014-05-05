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

/**
 * Class OpenExchangeRatesProvider
 */
class OpenExchangeRatesProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OpenExchangeRatesService
     *
     * A holder for a OpenExchangeRatesService like in Mrzard bundle
     */
    protected $mockOpenExchangeRatesService;

    /**
     * @var array
     *
     * Small currency list for tests
     */
    protected $smallCurrencyList = [
        'EUR' => 'Euro',
        'USD' => 'United States Dollar',
        'GBP' => 'Great Britain Pound'
    ];


    /**
     * @var array
     *
     * Small exchange rates list
     */
    protected $smallExchangeRateList = [
        'rates' => [
            'EUR' => 1.0,
            'USD' => 1.375400000,
            'GBP' => 0.826860647
        ]
    ];

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.currency.service.exchange_rates_provider';
    }


    /**
     * Set up before each test
     */
    public function setUp()
    {
        if (!class_exists("Mrzard\\OpenExchangeRatesBundle\\Service\\OpenExchangeRatesService")) {
            return;
        }

        $this->mockOpenExchangeRatesService = $this
            ->getMockBuilder(
                'Mrzard\\OpenExchangeRatesBundle\\Service\\OpenExchangeRatesService'
            )
            ->disableOriginalConstructor()
            ->setMethods(['getCurrencies', 'getLatest'])
            ->getMock();

        $this->mockOpenExchangeRatesService
            ->expects($this->any())
            ->method('getCurrencies')
            ->willReturn($this->smallCurrencyList);

        $this->mockOpenExchangeRatesService
            ->expects($this->any())
            ->method('getLatest')
            ->withAnyParameters()
            ->willReturn($this->smallExchangeRateList);
    }


    /**
     * Test get currencies
     */
    public function testGetCurrencies()
    {
        if (!class_exists("Mrzard\\OpenExchangeRatesBundle\\Service\\OpenExchangeRatesService")) {
            $this->markTestSkipped(
                'To run this test please install mrzard/open-exchange-rates-bundle'
            );
        }

        $openExchangeRatesProvider = new OpenExchangeRatesProvider(
            $this->mockOpenExchangeRatesService
        );

        $this->assertEquals(
            $this->smallCurrencyList,
            $openExchangeRatesProvider->getCurrencies(),
            'Currencies lists do not match'
        );
    }


    /**
     * Test that exchange rates are the ones we expect
     */
    public function testGetExchangeRates()
    {
        if (!class_exists("Mrzard\\OpenExchangeRatesBundle\\Service\\OpenExchangeRatesService")) {
            $this->markTestSkipped(
                'To run this test please install mrzard/open-exchange-rates-bundle'
            );
        }

        $openExchangeRatesProvider = new OpenExchangeRatesProvider(
            $this->mockOpenExchangeRatesService
        );

        $this->assertEquals(
            $this->smallExchangeRateList['rates'],
            $openExchangeRatesProvider->getExchangeRates('EUR', array('EUR', 'USD', 'GBP')),
            'Exchange rates lists do not match'
        );

        $this->assertEquals(
            ['EUR' => $this->smallExchangeRateList['rates']['EUR']],
            $openExchangeRatesProvider->getExchangeRates('EUR', array('EUR')),
            'Exchange rates lists do not match - EUR EUR'
        );

        $this->assertEquals(
            ['USD' => $this->smallExchangeRateList['rates']['USD']],
            $openExchangeRatesProvider->getExchangeRates('EUR', array('USD')),
            'Exchange rates lists do not match - EUR USD'
        );
    }
}
