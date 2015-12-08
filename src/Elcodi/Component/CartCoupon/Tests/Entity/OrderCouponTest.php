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

namespace Elcodi\Component\CartCoupon\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\CartCoupon\Entity\OrderCoupon;
use Elcodi\Component\Core\Tests\Entity\Traits;

class OrderCouponTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait;

    const CURRENCY_INTERFACE = 'Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface';
    const MONEY_INTERFACE = 'Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface';

    /**
     * @var OrderCoupon
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new OrderCoupon();
    }

    public function testOrder()
    {
        $order = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\OrderInterface');

        $setterOutput = $this->object->setOrder($order);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getOrder();
        $this->assertSame($order, $getterOutput);
    }

    public function testCoupon()
    {
        $coupon = $this->getMock('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $setterOutput = $this->object->setCoupon($coupon);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCoupon();
        $this->assertSame($coupon, $getterOutput);
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

    public function testAmount()
    {
        $money = $this->getMock(self::MONEY_INTERFACE);
        $amount = rand();
        $currency = $this->getMock(self::CURRENCY_INTERFACE);

        $currency
            ->method('getIso')
            ->willReturn('EUR');

        $money
            ->method('getAmount')
            ->willReturn($amount);
        $money
            ->method('getCurrency')
            ->willReturn($currency);

        $setterOutput = $this->object->setAmount($money);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAmount();
        $this->assertInstanceOf(self::MONEY_INTERFACE, $getterOutput);
    }
}
