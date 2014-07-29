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

namespace Elcodi\CurrencyBundle\Tests\UnitTest\Twig;

use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Factory\CurrencyFactory;
use Elcodi\CurrencyBundle\Twig\PrintMoneyExtension;
use Elcodi\LanguageBundle\Entity\Locale;

/**
 * Class PrintMoneyExtensionTest
 */
class PrintMoneyExtensionTest extends \PHPUnit_Framework_TestCase
{
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
        $currencyFactory->setEntityNamespace('Elcodi\CurrencyBundle\Entity\Currency');

        $priceExtension = new PrintMoneyExtension(
            $this->getMock('Elcodi\CurrencyBundle\Services\CurrencyConverter', [], [], '', false),
            $this->getMock('Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper', [], [], '', false),
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
            [1330000, 'USD', '$', new Locale('es_ES'), '13.300,00 $'],
            [800000, 'GBP', '£', new Locale('es_ES'), '8.000,00 £'],
            [100000, 'EUR', '€', new Locale('es_ES'), '1.000,00 €'],
            [1330000, 'USD', '$', new Locale('en_GB'), '$13,300.00'],
            [800000, 'GBP', '£', new Locale('en_GB'), '£8,000.00'],
            [100000, 'EUR', '€', new Locale('en_GB'), '€1,000.00'],
        ];
    }

    /**
     * @expectedException \Exception
     */
    public function testCurrencyRateNotFoundThrowsException()
    {
        $priceExtension = new PrintMoneyExtension(
            $this->getMock('Elcodi\CurrencyBundle\Services\CurrencyConverter', [], [], '', false),
            $this->getMock('Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper', [], [], '', false),
            new Locale('es_ES')
        );

        $currencyFactory = new CurrencyFactory();
        $currencyFactory->setEntityNamespace('Elcodi\CurrencyBundle\Entity\Currency');

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
