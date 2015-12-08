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

use Elcodi\Component\Cart\Entity\Cart;
use Elcodi\Component\Core\Tests\Entity\Traits;

class CartTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait, Traits\DateTimeTrait;

    const ADDRESS_INTERFACE = 'Elcodi\Component\Geo\Entity\Interfaces\AddressInterface';
    const CURRENCY_INTERFACE = 'Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface';
    const MONEY_INTERFACE = 'Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface';
    const CART_LINE_INTERFACE = 'Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface';

    /**
     * @var Cart
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Cart();
    }

    public function testLoaded()
    {
        $loaded = (bool) rand(0, 1);

        $setterOutput = $this->object->setLoaded($loaded);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->isLoaded();
        $this->assertSame($loaded, $getterOutput);
    }

    public function testCustomer()
    {
        $customer = $this->getMock('Elcodi\Component\User\Entity\Interfaces\CustomerInterface');

        $setterOutput = $this->object->setCustomer($customer);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCustomer();
        $this->assertSame($customer, $getterOutput);
    }

    public function testOrder()
    {
        $order = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\OrderInterface');

        $setterOutput = $this->object->setOrder($order);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getOrder();
        $this->assertSame($order, $getterOutput);
    }

    public function testOrdered()
    {
        $ordered = (bool) rand(0, 1);

        $setterOutput = $this->object->setOrdered($ordered);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->isOrdered();
        $this->assertSame($ordered, $getterOutput);
    }

    public function testCartLines()
    {
        $e1 = $this->getMock(self::CART_LINE_INTERFACE);
        $e2 = $this->getMock(self::CART_LINE_INTERFACE);

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setCartLines($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCartLines();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(self::CART_LINE_INTERFACE, $getterOutput);

        $adderOutput = $this->object->addCartLine($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getCartLines();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(self::CART_LINE_INTERFACE, $getterOutput);

        $removerOutput = $this->object->removeCartLine($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getCartLines();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(self::CART_LINE_INTERFACE, $getterOutput);

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testQuantity()
    {
        $quantity = (bool) rand(0, 1);

        $setterOutput = $this->object->setQuantity($quantity);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getQuantity();
        $this->assertSame($quantity, $getterOutput);
    }

    public function testGetTotalItemNumber()
    {
        $e1 = $this->getMock(self::CART_LINE_INTERFACE);
        $e2 = $this->getMock(self::CART_LINE_INTERFACE);

        $collection = new ArrayCollection([
            $e1,
        ]);

        $this->object->setCartLines($collection);

        $this->assertSame(0, $this->object->getTotalItemNumber());

        $e1
            ->method('getQuantity')
            ->willReturn(1);
        $this->assertSame(1, $this->object->getTotalItemNumber());

        $e2
            ->method('getQuantity')
            ->willReturn(1);
        $this->assertSame(2, $this->object->getTotalItemNumber());
    }

    public function testProductAmount()
    {
        $money = $this->getMock(self::MONEY_INTERFACE);

        $setterOutput = $this->object->setProductAmount($money);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getProductAmount();
        $this->assertSame($money, $getterOutput);
    }

    public function testCouponAmount()
    {
        $money = $this->getMock(self::MONEY_INTERFACE);

        $setterOutput = $this->object->setCouponAmount($money);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCouponAmount();
        $this->assertSame($money, $getterOutput);
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

    public function testAmount()
    {
        $money = $this->getMock(self::MONEY_INTERFACE);

        $setterOutput = $this->object->setAmount($money);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAmount();
        $this->assertSame($money, $getterOutput);
    }

    public function testGetDepth()
    {
        $e1 = $this->getMock(self::CART_LINE_INTERFACE);
        $e2 = $this->getMock(self::CART_LINE_INTERFACE);

        $collection = new ArrayCollection([
            $e1,
        ]);

        $this->object->setCartLines($collection);

        $this->assertSame(0, $this->object->getDepth());

        $e1
            ->method('getDepth')
            ->willReturn(1);
        $this->assertSame(1, $this->object->getDepth());

        $e2
            ->method('getDepth')
            ->willReturn(-1);
        $this->assertSame(1, $this->object->getDepth());
    }

    public function testGetHeight()
    {
        $e1 = $this->getMock(self::CART_LINE_INTERFACE);
        $e2 = $this->getMock(self::CART_LINE_INTERFACE);

        $collection = new ArrayCollection([
            $e1,
        ]);

        $this->object->setCartLines($collection);

        $this->assertSame(0, $this->object->getHeight());

        $e1
            ->method('getHeight')
            ->willReturn(1);
        $this->assertSame(1, $this->object->getHeight());

        $e2
            ->method('getHeight')
            ->willReturn(-1);
        $this->assertSame(1, $this->object->getHeight());
    }

    public function testGetWidth()
    {
        $e1 = $this->getMock(self::CART_LINE_INTERFACE);
        $e2 = $this->getMock(self::CART_LINE_INTERFACE);

        $collection = new ArrayCollection([
            $e1,
        ]);

        $this->object->setCartLines($collection);

        $this->assertSame(0, $this->object->getWidth());

        $e1
            ->method('getWidth')
            ->willReturn(1);
        $this->assertSame(1, $this->object->getWidth());

        $e2
            ->method('getWidth')
            ->willReturn(-1);
        $this->assertSame(1, $this->object->getWidth());
    }

    public function testGetWeight()
    {
        $e1 = $this->getMock(self::CART_LINE_INTERFACE);
        $e2 = $this->getMock(self::CART_LINE_INTERFACE);

        $collection = new ArrayCollection([
            $e1,
        ]);

        $this->object->setCartLines($collection);

        $this->assertSame(0, $this->object->getWeight());

        $e1
            ->method('getWeight')
            ->willReturn(1);
        $this->assertSame(1, $this->object->getWeight());

        $e2
            ->method('getWeight')
            ->willReturn(-1);
        $this->assertSame(1, $this->object->getWeight());
    }

    public function testDeliveryAddress()
    {
        $address = $this->getMock(self::ADDRESS_INTERFACE);

        $setterOutput = $this->object->setDeliveryAddress($address);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDeliveryAddress();
        $this->assertSame($address, $getterOutput);
    }

    public function testBillingAddress()
    {
        $address = $this->getMock(self::ADDRESS_INTERFACE);

        $setterOutput = $this->object->setBillingAddress($address);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getBillingAddress();
        $this->assertSame($address, $getterOutput);
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

    public function testCheapestShippingMethod()
    {
        $cheapestShippingMethod = sha1(rand());

        $setterOutput = $this->object->setCheapestShippingMethod($cheapestShippingMethod);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCheapestShippingMethod();
        $this->assertSame($cheapestShippingMethod, $getterOutput);
    }
}
