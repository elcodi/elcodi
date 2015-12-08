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

namespace Elcodi\Component\Cart\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Core\Tests\Entity\Traits;

class OrderTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait, Traits\DateTimeTrait;

    const ADDRESS_INTERFACE = 'Elcodi\Component\Geo\Entity\Interfaces\AddressInterface';
    const CURRENCY_INTERFACE = 'Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface';
    const MONEY_INTERFACE = 'Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface';
    const ORDER_LINE_INTERFACE = 'Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface';
    const STATE_LINE_STACK = 'Elcodi\Component\StateTransitionMachine\Entity\StateLineStack';

    /**
     * @var Order
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Order();
    }

    public function testCustomer()
    {
        $customer = $this->getMock('Elcodi\Component\User\Entity\Interfaces\CustomerInterface');

        $setterOutput = $this->object->setCustomer($customer);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCustomer();
        $this->assertSame($customer, $getterOutput);
    }

    public function testCart()
    {
        $cart = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');

        $setterOutput = $this->object->setCart($cart);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCart();
        $this->assertSame($cart, $getterOutput);
    }

    public function testOrderLines()
    {
        $e1 = $this->getMock(self::ORDER_LINE_INTERFACE);
        $e2 = $this->getMock(self::ORDER_LINE_INTERFACE);

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setOrderLines($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getOrderLines();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(self::ORDER_LINE_INTERFACE, $getterOutput);

        $adderOutput = $this->object->addOrderLine($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getOrderLines();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(self::ORDER_LINE_INTERFACE, $getterOutput);

        $removerOutput = $this->object->removeOrderLine($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getOrderLines();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(self::ORDER_LINE_INTERFACE, $getterOutput);

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testQuantity()
    {
        $quantity = microtime();

        $setterOutput = $this->object->setQuantity($quantity);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getQuantity();
        $this->assertSame($quantity, $getterOutput);
    }

    public function testCouponAmount()
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

        $setterOutput = $this->object->setCouponAmount($money);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCouponAmount();
        $this->assertInstanceOf(self::MONEY_INTERFACE, $getterOutput);
    }

    public function testShippingAmount()
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

        $setterOutput = $this->object->setShippingAmount($money);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getShippingAmount();
        $this->assertInstanceOf(self::MONEY_INTERFACE, $getterOutput);
    }

    public function testShippingMethod()
    {
        $shippingMethod = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Entity\ShippingMethod')
            ->disableOriginalConstructor()
            ->getMock();

        $setterOutput = $this->object->setShippingMethod($shippingMethod);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getShippingMethod();
        $this->assertSame($shippingMethod, $getterOutput);
    }

    public function testShippingMethodExtra()
    {
        $shippingMethodExtra = range(1, 10);

        $setterOutput = $this->object->setShippingMethodExtra($shippingMethodExtra);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getShippingMethodExtra();
        $this->assertSame($shippingMethodExtra, $getterOutput);
    }

    public function testPaymentMethod()
    {
        $paymentMethod = $this
            ->getMockBuilder('Elcodi\Component\Payment\Entity\PaymentMethod')
            ->disableOriginalConstructor()
            ->getMock();

        $setterOutput = $this->object->setPaymentMethod($paymentMethod);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPaymentMethod();
        $this->assertSame($paymentMethod, $getterOutput);
    }

    public function testPaymentMethodExtra()
    {
        $paymentMethodExtra = range(1, 10);

        $setterOutput = $this->object->setPaymentMethodExtra($paymentMethodExtra);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPaymentMethodExtra();
        $this->assertSame($paymentMethodExtra, $getterOutput);
    }

    public function testDeliveryAddress()
    {
        $address = $this->getMock(self::ADDRESS_INTERFACE);

        $setterOutput = $this->object->setDeliveryAddress($address);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDeliveryAddress();
        $this->assertSame($address, $getterOutput);
    }

    public function testPaymentStateLineStack()
    {
        $paymentStateLineStack = $this
            ->getMockBuilder(self::STATE_LINE_STACK)
            ->disableOriginalConstructor()
            ->getMock();

        $paymentStateLineStack
            ->method('getStateLines')
            ->willReturn(new ArrayCollection());

        $setterOutput = $this->object->setPaymentStateLineStack($paymentStateLineStack);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPaymentStateLineStack();
        $this->assertInstanceOf(self::STATE_LINE_STACK, $getterOutput);
    }

    public function testBillingAddress()
    {
        $address = $this->getMock(self::ADDRESS_INTERFACE);

        $setterOutput = $this->object->setBillingAddress($address);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getBillingAddress();
        $this->assertSame($address, $getterOutput);
    }
}
