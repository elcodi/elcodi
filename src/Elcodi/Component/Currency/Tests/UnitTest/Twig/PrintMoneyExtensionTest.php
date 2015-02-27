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
 * @author Elcodi Team <tech@elcodi.com>
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
     * Test price output
     *
     * @dataProvider dataPrintPrice
     * @
     */
    public function testPrintPrice(
        $amount,
        $iso,
        $symbol,
        $locale,
        $result
    ) {
        $this->markTestSkipped("Problems in local environments");

        $currencyFactory = new CurrencyFactory();
        $currencyFactory->setEntityNamespace('Elcodi\Component\Currency\Entity\Currency');

        $priceExtension = new PrintMoneyExtension(
            $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false),
            $this->getMock('Elcodi\Component\Currency\Wrapper\CurrencyWrapper', [], [], '', false),
            $locale
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
        $locale = $this->getMock('Elcodi\Component\Language\Entity\Interfaces\LocaleInterface');
        $locale
            ->expects($this->any())
            ->method('getIso')
            ->willReturn('es_ES')
        ;

        $priceExtension = new PrintMoneyExtension(
            $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false),
            $this->getMock('Elcodi\Component\Currency\Wrapper\CurrencyWrapper', [], [], '', false),
            $locale
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
