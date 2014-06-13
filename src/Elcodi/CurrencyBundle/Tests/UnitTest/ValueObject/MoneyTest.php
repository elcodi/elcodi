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

namespace Elcodi\CurrencyBundle\Tests\UnitTest\ValueObject;

use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Entity\Currency;

/**
 * Class MoneyTest
 *
 * Tests for Money Value Object
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
{
    protected $currencyMockUSD;

    /**
     * @var Money
     */
    private $oneHundredDollars;

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

        $this->oneHundredDollars = new Money(100, $this->currencyMockUSD);
    }

    /**
     * @covers \Elcodi\CurrencyBundle\Entity\Money::__construct
     * @covers \Elcodi\CurrencyBundle\Entity\Money::newWrappedMoneyFromMoney
     */
    public function testInitialize()
    {
        $currencyMock = new Currency();
        $currencyMock->setIso('USD');

        $twoHundredDollars = new Money(200, $currencyMock);

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
        $fiftyDollars = new Money(50, $this->currencyMockUSD);

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
        $fiftyDollars = new Money(50, $this->currencyMockUSD);

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
        $oneHundredFiftyDollars = new Money(150, $this->currencyMockUSD);

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
        $oneHundredDollars = new Money(100, $this->currencyMockUSD);

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
        $fiftyDollars = new Money(50, $this->currencyMockUSD);

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

        $fiftyEuros = new Money(50, $currencyMockEUR);

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
        $fiftyDollars = new Money(50, $this->currencyMockUSD);
        $this->assertEquals(
            1,
            $this
                ->oneHundredDollars
                ->compareTo($fiftyDollars)
        );

        /* Testing less-than */
        $oneHundredFiftyDollars = new Money(150, $this->currencyMockUSD);
        $this->assertEquals(
            -1,
            $this
                ->oneHundredDollars
                ->compareTo($oneHundredFiftyDollars)
        );

        /* Testing equals */
        $oneHundredDollars = new Money(100, $this->currencyMockUSD);
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
        $fiftyDollars = new Money(50, $this->currencyMockUSD);

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
        $fiftyDollars = new Money(50, $this->currencyMockUSD);

        $this->assertTrue(
            $fiftyDollars->isLessThan($this->oneHundredDollars)
        );
    }
}
