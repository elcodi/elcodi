<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Currency\Tests\UnitTest\ValueObject;

use Elcodi\Component\Currency\Entity\Currency;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class MoneyTest.
 *
 * Tests for Money Value Object
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Money
     *
     * currencyMockUSD
     */
    protected $currencyMockUSD;

    /**
     * @var Money
     *
     * One hundred dollars
     */
    private $oneHundredDollars;

    /**
     * Setup.
     */
    public function setup()
    {
        $this->currencyMockUSD = $this->getMock(
            'Elcodi\Component\Currency\Entity\Currency',
            ['getIso']
        );

        $this
            ->currencyMockUSD
            ->expects($this->any())
            ->method('getIso')
            ->will($this->returnValue('USD'));

        $this->oneHundredDollars = Money::create(100, $this->currencyMockUSD);
    }

    public function testInitialize()
    {
        $currencyMock = new Currency();
        $currencyMock->setIso('USD');

        $twoHundredDollars = Money::create(200, $currencyMock);

        $this->assertInstanceOf('Elcodi\Component\Currency\Entity\Money', $twoHundredDollars);
    }

    public function testGetCurrency()
    {
        $this->assertInstanceOf(
            'Elcodi\Component\Currency\Entity\Currency',
            $this->oneHundredDollars->getCurrency()
        );
    }

    public function testAmountIsNumeric()
    {
        $this->assertInternalType(
            'int',
            $this->oneHundredDollars->getAmount()
        );
    }

    public function testAddMoney()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertEquals(
            150,
            $this->oneHundredDollars->add($fiftyDollars)->getAmount()
        );
    }

    public function testMethodWillReturnMoneyInstance()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertInstanceOf(
            'Elcodi\Component\Currency\Entity\Money',
            $this->oneHundredDollars->subtract($fiftyDollars)
        );
        $this->assertInstanceOf(
            'Elcodi\Component\Currency\Entity\Money',
            $this->oneHundredDollars->add($fiftyDollars)
        );
    }

    public function testSubtractMoney()
    {
        $oneHundredFiftyDollars = Money::create(150, $this->currencyMockUSD);

        $this->assertEquals(
            -50,
            $this
                ->oneHundredDollars
                ->subtract($oneHundredFiftyDollars)
                ->getAmount()
        );
    }

    public function testMultiplyMoneyByFactor()
    {
        $this->assertEquals(
            250,
            $this
                ->oneHundredDollars
                ->multiply(2.5)
                ->getAmount()
        );
    }

    /**
     * @covers \Elcodi\Component\Currency\Entity\Money::equals
     */
    public function testMoneyIsEqualTo()
    {
        $oneHundredDollars = Money::create(100, $this->currencyMockUSD);

        $this->assertTrue(
            $this
                ->oneHundredDollars
                ->equals($oneHundredDollars)
        );
    }

    public function testMoneyIsNotEqualTo()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertFalse(
            $this
                ->oneHundredDollars
                ->equals($fiftyDollars)
        );
    }

    /**
     * @expectedException \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function testCurrencyMismatchException()
    {
        $currencyMockEUR = $this->getMock(
            'Elcodi\Component\Currency\Entity\Currency',
            ['getIso']
        );

        $currencyMockEUR
            ->expects($this->any())
            ->method('getIso')
            ->will($this->returnValue('EUR'));

        $fiftyEuros = Money::create(50, $currencyMockEUR);

        $this->assertFalse(
            $this
                ->oneHundredDollars
                ->equals($fiftyEuros)
        );
    }

    public function testCompareTo()
    {
        /* Testing greater-than */
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);
        $this->assertEquals(
            1,
            $this
                ->oneHundredDollars
                ->compareTo($fiftyDollars)
        );

        /* Testing less-than */
        $oneHundredFiftyDollars = Money::create(150, $this->currencyMockUSD);
        $this->assertEquals(
            -1,
            $this
                ->oneHundredDollars
                ->compareTo($oneHundredFiftyDollars)
        );

        /* Testing equals */
        $oneHundredDollars = Money::create(100, $this->currencyMockUSD);
        $this->assertEquals(
            0,
            $this
                ->oneHundredDollars
                ->compareTo($oneHundredDollars)
        );
    }

    public function testIsGreaterThan()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertTrue(
            $this
                ->oneHundredDollars
                ->isGreaterThan($fiftyDollars)
        );
    }

    public function testIsLessThan()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertTrue(
            $fiftyDollars->isLessThan($this->oneHundredDollars)
        );
    }
}
