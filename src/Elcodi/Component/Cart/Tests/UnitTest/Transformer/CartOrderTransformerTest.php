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

namespace Elcodi\Component\Cart\Tests\UnitTest\Transformer;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Cart\Entity\Cart;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Cart\EventDispatcher\OrderEventDispatcher;
use Elcodi\Component\Cart\Factory\OrderFactory;
use Elcodi\Component\Cart\Transformer\CartLineOrderLineTransformer;
use Elcodi\Component\Cart\Transformer\CartOrderTransformer;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\User\Entity\Customer;

/**
 * Class CartOrderTransformerTest.
 */
class CartOrderTransformerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CartOrderTransformer
     *
     * CartOrderTransformer
     */
    protected $cartOrderTransformer;

    /**
     * @var OrderFactory
     *
     * Order factory
     */
    protected $orderFactory;

    /**
     * @var CartLineOrderLineTransformer
     *
     * CartLineOrderLineTransformer
     */
    protected $cartLineOrderLineTransformer;

    /**
     * Setup.
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var OrderEventDispatcher         $orderEventDispatcher
         * @var CartLineOrderLineTransformer $cartLineOrderLineTransformer
         * @var OrderFactory                 $orderFactory
         */
        $orderEventDispatcher = $this
            ->getMock(
                'Elcodi\Component\Cart\EventDispatcher\OrderEventDispatcher',
                [], [], '', false
            );

        $orderFactory = $this->getMock('Elcodi\Component\Cart\Factory\OrderFactory', [], [], '', false);
        $order = new Order();
        $orderFactory
            ->expects($this->any())
            ->method('create')
            ->will($this->returnValue($order));

        $cartLineOrderLineTransformer = $this->getMock(
            'Elcodi\Component\Cart\Transformer\CartLineOrderLineTransformer',
            [], [], '', false
        );

        $cartOrderTransformer = new CartOrderTransformer(
            $orderEventDispatcher,
            $cartLineOrderLineTransformer,
            $orderFactory
        );

        $this->orderFactory = $orderFactory;
        $this->cartOrderTransformer = $cartOrderTransformer;
        $this->cartLineOrderLineTransformer = $cartLineOrderLineTransformer;
    }

    /**
     * test Create Order from Cart.
     *
     * @group order
     */
    public function testCreateOrderFromCartNewOrder()
    {
        /**
         * @var OrderInterface    $order
         * @var CurrencyInterface $currency
         */
        $order = $this->getMock('Elcodi\Component\Cart\Entity\Order', null);
        $currency = $this->getMock('Elcodi\Component\Currency\Entity\Currency', null);
        $currency->setIso('EUR');

        $this
            ->orderFactory
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($order));

        $this
            ->cartLineOrderLineTransformer
            ->expects($this->any())
            ->method('createOrderLinesByCartLines')
            ->will($this->returnValue(new ArrayCollection()));

        $customer = new Customer();
        $cart = new Cart();
        $cart
            ->setCustomer($customer)
            ->setPurchasableAmount(Money::create(20, $currency))
            ->setCouponAmount(Money::create(0, $currency))
            ->setAmount(Money::create(20, $currency))
            ->setShippingAmount($this->getMock('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface'))
            ->setCartLines(new ArrayCollection());

        $this
            ->cartOrderTransformer
            ->createOrderFromCart($cart);
    }

    /**
     * test Create Order from Cart.
     *
     * @group order
     */
    public function testCreateOrderFromCartNewOrderExistingOrder()
    {
        /**
         * @var OrderInterface    $order
         * @var CurrencyInterface $currency
         */
        $order = $this->getMock('Elcodi\Component\Cart\Entity\Order', null);
        $currency = $this->getMock('Elcodi\Component\Currency\Entity\Currency', null);
        $currency->setIso('EUR');

        $this
            ->orderFactory
            ->expects($this->never())
            ->method('create')
            ->will($this->returnValue($order));

        $this
            ->cartLineOrderLineTransformer
            ->expects($this->any())
            ->method('createOrderLinesByCartLines')
            ->will($this->returnValue(new ArrayCollection()));

        $customer = new Customer();
        $cart = new Cart();
        $cart
            ->setCustomer($customer)
            ->setPurchasableAmount(Money::create(20, $currency))
            ->setCouponAmount(Money::create(0, $currency))
            ->setOrder($order)
            ->setShippingAmount($this->getMock('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface'))
            ->setAmount(Money::create(20, $currency))
            ->setCartLines(new ArrayCollection());

        $this
            ->cartOrderTransformer
            ->createOrderFromCart($cart);
    }

    /**
     * Test dimensions transformation.
     *
     * @group Order
     */
    public function testCreateOrderFromCartDimensions()
    {
        /**
         * @var OrderInterface    $order
         * @var CurrencyInterface $currency
         */
        $order = $this->getMock('Elcodi\Component\Cart\Entity\Order', null);
        $currency = $this->getMock('Elcodi\Component\Currency\Entity\Currency', null);
        $currency->setIso('EUR');

        $this
            ->orderFactory
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($order));

        $this
            ->cartLineOrderLineTransformer
            ->expects($this->any())
            ->method('createOrderLinesByCartLines')
            ->will($this->returnValue(new ArrayCollection()));

        $cart = $this->getMock('Elcodi\Component\Cart\Entity\Cart');

        $cart
            ->expects($this->any())
            ->method('getCartLines')
            ->will($this->returnValue(new ArrayCollection()));
        $cart
            ->expects($this->any())
            ->method('getShippingAmount')
            ->will($this->returnValue($this->getMock('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface')));

        $cart
            ->expects($this->any())
            ->method('getCustomer')
            ->will($this->returnValue(new Customer()));

        $cart
            ->expects($this->any())
            ->method('getPurchasableAmount')
            ->will($this->returnValue(Money::create(10, $currency)));

        $cart
            ->expects($this->any())
            ->method('getCouponAmount')
            ->will($this->returnValue(Money::create(0, $currency)));

        $cart
            ->expects($this->any())
            ->method('getAmount')
            ->will($this->returnValue(Money::create(10, $currency)));

        $cart
            ->expects($this->any())
            ->method('getWeight')
            ->will($this->returnValue(10));

        $cart
            ->expects($this->any())
            ->method('getHeight')
            ->will($this->returnValue(11));

        $cart
            ->expects($this->any())
            ->method('getWidth')
            ->will($this->returnValue(12));

        $cart
            ->expects($this->any())
            ->method('getDepth')
            ->will($this->returnValue(13));

        $order = $this
            ->cartOrderTransformer
            ->createOrderFromCart($cart);

        $this->assertEquals(10, $order->getWeight());
        $this->assertEquals(11, $order->getHeight());
        $this->assertEquals(12, $order->getWidth());
        $this->assertEquals(13, $order->getDepth());
    }
}
