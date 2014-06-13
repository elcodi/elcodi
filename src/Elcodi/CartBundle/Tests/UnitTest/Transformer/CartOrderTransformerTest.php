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

namespace Elcodi\CartBundle\Tests\UnitTest\Transformer;

use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use PHPUnit_Framework_TestCase;

use Elcodi\CartBundle\Transformer\CartLineOrderLineTransformer;
use Elcodi\CartBundle\EventDispatcher\OrderEventDispatcher;
use Elcodi\CartBundle\Transformer\CartOrderTransformer;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Services\OrderLineManager;
use Elcodi\CartBundle\Services\OrderManager;
use Elcodi\CartBundle\Factory\OrderFactory;
use Elcodi\UserBundle\Entity\Customer;
use Elcodi\CartBundle\Entity\Cart;

/**
 * Class CartOrderTransformerTest
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
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var OrderEventDispatcher         $orderEventDispatcher
         * @var CartLineOrderLineTransformer $cartLineOrderLineTransformer
         * @var OrderLineManager             $orderLineManager
         * @var OrderFactory                 $orderFactory
         * @var OrderManager                 $orderManager
         */
        $orderEventDispatcher = $this
            ->getMock(
                'Elcodi\CartBundle\EventDispatcher\OrderEventDispatcher',
                [], [], '', false
            );

        $orderFactory = $this->getMock('Elcodi\CartBundle\Factory\OrderFactory');
        $cartLineOrderLineTransformer = $this->getMock(
            'Elcodi\CartBundle\Transformer\CartLineOrderLineTransformer',
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
     * test Create Order from Cart
     *
     * @group order
     */
    public function testCreateOrderFromCartNewOrder()
    {
        /**
         * @var OrderInterface    $order
         * @var CurrencyInterface $currency
         */
        $order = $this->getMock('Elcodi\CartBundle\Entity\Order', null);
        $currency = $this->getMock('Elcodi\CurrencyBundle\Entity\Currency', null);
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
            ->will($this->returnValue(new ArrayCollection));

        $customer = new Customer();
        $cart = new Cart();
        $cart
            ->setCustomer($customer)
            ->setQuantity(10)
            ->setProductAmount(Money::create(20, $currency))
            ->setAmount(Money::create(20, $currency))
            ->setCartLines(new ArrayCollection);

        $this
            ->cartOrderTransformer
            ->createOrderFromCart($cart);
    }

    /**
     * test Create Order from Cart
     *
     * @group order
     */
    public function testCreateOrderFromCartNewOrderExistingOrder()
    {
        /**
         * @var OrderInterface    $order
         * @var CurrencyInterface $currency
         */
        $order = $this->getMock('Elcodi\CartBundle\Entity\Order', null);
        $currency = $this->getMock('Elcodi\CurrencyBundle\Entity\Currency', null);
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
            ->will($this->returnValue(new ArrayCollection));

        $customer = new Customer();
        $cart = new Cart();
        $cart
            ->setCustomer($customer)
            ->setQuantity(10)
            ->setProductAmount(Money::create(20, $currency))
            ->setOrder($order)
            ->setAmount(Money::create(20, $currency))
            ->setCartLines(new ArrayCollection);

        $this
            ->cartOrderTransformer
            ->createOrderFromCart($cart);
    }
}
