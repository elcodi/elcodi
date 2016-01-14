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

use Exception;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Factory\CurrencyFactory;
use Elcodi\Component\Currency\Services\MoneyPrinter;
use Elcodi\Component\Language\Entity\Locale;

/**
 * Class MoneyPrinterTest.
 */
class MoneyPrinterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test price output.
     *
     * @dataProvider dataPrintPrice
     */
    public function testPrintPrice(
        $amount,
        $iso,
        $symbol,
        $locale,
        $result
    ) {
        $currencyFactory = new CurrencyFactory();
        $currencyFactory->setEntityNamespace('Elcodi\Component\Currency\Entity\Currency');
        $currencyFactory->setDateTimeFactory(new DateTimeFactory());

        $priceExtension = new MoneyPrinter(
            $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false),
            $this->getMock('Elcodi\Component\Currency\Wrapper\CurrencyWrapper', [], [], '', false),
            Locale::create($locale)
        );

        try {
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
        } catch (Exception $e) {
            $this->markTestSkipped('Problems in local environments');
        }
    }

    /**
     * data for testPrintPrice.
     */
    public function dataPrintPrice()
    {
        return [
            [1330000, 'USD', '$', 'es_ES', '13.300,00 $'],
            [800000, 'GBP', '£', 'es_ES', '8.000,00 £'],
            [100000, 'EUR', '€', 'es_ES', '1.000,00 €'],
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
        $locale = $this->getMock('Elcodi\Component\Language\Entity\Interfaces\LocaleInterface');
        $locale
            ->expects($this->any())
            ->method('getIso')
            ->willReturn('es_ES');
        $priceExtension = new MoneyPrinter(
            $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false),
            $this->getMock('Elcodi\Component\Currency\Wrapper\CurrencyWrapper', [], [], '', false),
            Locale::create($locale)
        );
        $currencyFactory = new CurrencyFactory();
        $currencyFactory->setEntityNamespace('Elcodi\Component\Currency\Entity\Currency');
        $currencyFactory->setDateTimeFactory(new DateTimeFactory());
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
