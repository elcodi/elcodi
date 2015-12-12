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

namespace Elcodi\Component\Coupon\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Coupon\Entity\Coupon;

class CouponTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait,
        Traits\DateTimeTrait,
        Traits\EnabledTrait,
        Traits\ValidIntervalTrait;

    const CURRENCY_INTERFACE = 'Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface';
    const MONEY_INTERFACE = 'Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface';

    /**
     * @var Coupon
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Coupon();
    }

    public function testCode()
    {
        $code = sha1(rand());

        $setterOutput = $this->object->setCode($code);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCode();
        $this->assertSame($code, $getterOutput);
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testType()
    {
        $type = rand();

        $setterOutput = $this->object->setType($type);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getType();
        $this->assertSame($type, $getterOutput);
    }

    public function testEnforcement()
    {
        $enforcement = rand();

        $setterOutput = $this->object->setEnforcement($enforcement);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getEnforcement();
        $this->assertSame($enforcement, $getterOutput);
    }

    public function testPrice()
    {
        $price = $this->getMock(self::MONEY_INTERFACE);
        $amount = rand();
        $currency = $this->getMock(self::CURRENCY_INTERFACE);

        $currency
            ->method('getIso')
            ->willReturn('EUR');

        $price
            ->method('getAmount')
            ->willReturn($amount);
        $price
            ->method('getCurrency')
            ->willReturn($currency);

        $setterOutput = $this->object->setPrice($price);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPrice();
        $this->assertInstanceOf(self::MONEY_INTERFACE, $getterOutput);
    }

    public function testDiscount()
    {
        $discount = rand();

        $setterOutput = $this->object->setDiscount($discount);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDiscount();
        $this->assertSame($discount, $getterOutput);
    }

    public function testAbsolutePrice()
    {
        $absolutePrice = $this->getMock(self::MONEY_INTERFACE);
        $amount = rand();
        $currency = $this->getMock(self::CURRENCY_INTERFACE);

        $currency
            ->method('getIso')
            ->willReturn('EUR');

        $absolutePrice
            ->method('getAmount')
            ->willReturn($amount);
        $absolutePrice
            ->method('getCurrency')
            ->willReturn($currency);

        $setterOutput = $this->object->setAbsolutePrice($absolutePrice);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAbsolutePrice();
        $this->assertInstanceOf(self::MONEY_INTERFACE, $getterOutput);
    }

    public function testCount()
    {
        $count = rand();

        $setterOutput = $this->object->setCount($count);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCount();
        $this->assertSame($count, $getterOutput);
    }

    public function testUsed()
    {
        $used = rand();

        $setterOutput = $this->object->setUsed($used);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getUsed();
        $this->assertSame($used, $getterOutput);
    }

    public function testPriority()
    {
        $priority = rand();

        $setterOutput = $this->object->setPriority($priority);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPriority();
        $this->assertSame($priority, $getterOutput);
    }

    public function testMinimumPurchase()
    {
        $minimumPurchase = $this->getMock(self::MONEY_INTERFACE);
        $amount = rand();
        $currency = $this->getMock(self::CURRENCY_INTERFACE);

        $currency
            ->method('getIso')
            ->willReturn('EUR');

        $minimumPurchase
            ->method('getAmount')
            ->willReturn($amount);
        $minimumPurchase
            ->method('getCurrency')
            ->willReturn($currency);

        $setterOutput = $this->object->setMinimumPurchase($minimumPurchase);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getMinimumPurchase();
        $this->assertInstanceOf(self::MONEY_INTERFACE, $getterOutput);
    }

    public function testRule()
    {
        $rule = $this->getMock('Elcodi\Component\Rule\Entity\Interfaces\RuleInterface');

        $setterOutput = $this->object->setRule($rule);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getRule();
        $this->assertSame($rule, $getterOutput);
    }

    public function testStackable()
    {
        $stackable = rand();

        $setterOutput = $this->object->setStackable($stackable);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getStackable();
        $this->assertSame($stackable, $getterOutput);
    }

    public function testToString()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertSame($name, (string) $this->object);
    }

    public function testMakeUse()
    {
        $output = $this->object->makeUse();
        $this->assertInstanceOf(get_class($this->object), $output);

        $this->assertSame(1, $this->object->getUsed());

        $this->object->setEnabled(true);
        $this->object->setCount(1);

        $output = $this->object->makeUse();
        $this->assertInstanceOf(get_class($this->object), $output);
        $this->assertFalse($this->object->isEnabled());

        $this->object->setEnabled(true);
        $this->object->setCount(10);

        $output = $this->object->makeUse();
        $this->assertInstanceOf(get_class($this->object), $output);
        $this->assertTrue($this->object->isEnabled());
    }
}
