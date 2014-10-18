<?php

/*
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

namespace Elcodi\Component\Currency\Tests\UnitTest\Twig;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Factory\CurrencyFactory;
use Elcodi\Component\Currency\Twig\PrintMoneyExtension;

/**
 * Class PrintMoneyExtensionTest
 */
class PrintMoneyExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Skipping tests if Twig is not installed
     */
    public function setUp()
    {
        if (!class_exists('Twig_Extension')) {

            $this->markTestSkipped("Twig extension not installed");
        }
    }

    /**
     * Test price output
     *
     * @dataProvider dataPrintPrice
     */
    public function testPrintPrice(
        $amount,
        $iso,
        $symbol,
        $locale,
        $result
    )
    {
        $currencyFactory = new CurrencyFactory();
        $currencyFactory->setEntityNamespace('Elcodi\Component\Currency\Entity\Currency');

        $localAdapter = $this->getMock('Elcodi\Component\Currency\Adapter\LocaleProvider\Interfaces\LocaleProviderAdapterInterface');
        $localAdapter
            ->expects($this->any())
            ->method('getLocaleIso')
            ->will($this->returnValue($locale));

        $priceExtension = new PrintMoneyExtension(
            $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false),
            $this->getMock('Elcodi\Component\Currency\Wrapper\CurrencyWrapper', [], [], '', false),
            $localAdapter
        );

        $this->assertEquals(
            $result,
            $priceExtension->printMoney(
                Money::create(
                    $amount,
                    $currencyFactory
                        ->create()
                        ->setIso($iso)
                        ->setSymbol($symbol)
                )
            )
        );
    }

    /**
     * data for testPrintPrice
     */
    public function dataPrintPrice()
    {
        return [
            [1330000, 'USD', '$', 'es_ES', '13.300,00 $'],
            [800000, 'GBP', '£', 'es_ES', '8.000,00 £'],
            [100000, 'EUR', '€', 'es_ES', '1.000,00 €'],
            [1330000, 'USD', '$', 'en_GB', '$13,300.00'],
            [800000, 'GBP', '£', 'en_GB', '£8,000.00'],
            [100000, 'EUR', '€', 'en_GB', '€1,000.00'],
        ];
    }

    /**
     * @expectedException \Exception
     */
    public function testCurrencyRateNotFoundThrowsException()
    {
        $localAdapter = $this->getMock('Elcodi\Component\Currency\Adapter\LocaleProvider\Interfaces\LocaleProviderAdapterInterface');
        $localAdapter
            ->expects($this->any())
            ->method('getLocaleIso')
            ->will($this->returnValue('es_ES'));

        $priceExtension = new PrintMoneyExtension(
            $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false),
            $this->getMock('Elcodi\Component\Currency\Wrapper\CurrencyWrapper', [], [], '', false),
            $localAdapter
        );

        $currencyFactory = new CurrencyFactory();
        $currencyFactory->setEntityNamespace('Elcodi\Component\Currency\Entity\Currency');

        $priceExtension->printMoney(
            Money::create(
                1000,
                $currencyFactory
                    ->create()
                    ->setIso('US1')
            ),
            'US1'
        );

    }
}
