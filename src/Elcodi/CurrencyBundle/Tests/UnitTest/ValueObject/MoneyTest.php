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

namespace Elcodi\CurrencyBundle\Tests\UnitTest\ValueObject;

use Elcodi\CurrencyBundle\Entity\Currency;
use Elcodi\CurrencyBundle\Entity\Money;

/**
 * Class MoneyTest
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
     * Setup
     */
    public function setup()
    {
        $this->currencyMockUSD = $this->getMock(
            'Elcodi\CurrencyBundle\Entity\Currency',
            ['getIso']
        );

        $this
            ->currencyMockUSD
            ->expects($this->any())
            ->method('getIso')
            ->will($this->returnValue('USD'));

        $this->oneHundredDollars = Money::create(100, $this->currencyMockUSD);
    }

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::__construct
     * @covers \Elcodi\CurrencyBundle\Entity\Money::newWrappedMoneyFromMoney
     */
    public function testInitialize()
    {
        $currencyMock = new Currency();
        $currencyMock->setIso('USD');

        $twoHundredDollars = Money::create(200, $currencyMock);

        $this->assertInstanceOf('\Elcodi\CurrencyBundle\Entity\Money', $twoHundredDollars);
    }

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::getCurrency
     */
    public function testGetCurrency()
    {
        $this->assertInstanceOf(
            '\Elcodi\CurrencyBundle\Entity\Currency',
            $this->oneHundredDollars->getCurrency()
        );
    }

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::getAmount
     */
    public function testAmountIsNumeric()
    {
        $this->assertInternalType(
            'int',
            $this->oneHundredDollars->getAmount()
        );
    }

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::add
     */
    public function testAddMoney()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertEquals(
            150,
            $this->oneHundredDollars->add($fiftyDollars)->getAmount()
        );
    }

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::subtract
     * @covers \Elcodi\CurrencyBundle\Entity\Money::create
     */
    public function testMethodWillReturnMoneyInstance()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertInstanceOf(
            'Elcodi\CurrencyBundle\Entity\Money',
            $this->oneHundredDollars->subtract($fiftyDollars)
        );
        $this->assertInstanceOf(
            'Elcodi\CurrencyBundle\Entity\Money',
            $this->oneHundredDollars->add($fiftyDollars)
        );
    }

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::subtract
     */
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

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::multiply
     */
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

    /**q
     * @covers \Elcodi\CurrencyBundle\Entity\Money::equals
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

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::equals
     */
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
            'Elcodi\CurrencyBundle\Entity\Currency',
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

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::compareTo
     */
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

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::isGreaterThan
     */
    public function testIsGreaterThan()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertTrue(
            $this
                ->oneHundredDollars
                ->isGreaterThan($fiftyDollars)
        );
    }

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::isLessThan
     */
    public function testIsLessThan()
    {
        $fiftyDollars = Money::create(50, $this->currencyMockUSD);

        $this->assertTrue(
            $fiftyDollars->isLessThan($this->oneHundredDollars)
        );
    }
}
