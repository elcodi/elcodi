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

namespace Elcodi\Component\Cart\Tests\UnitTest\Factory;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Cart\Factory\OrderFactory;
use Elcodi\Component\Cart\Factory\OrderHistoryFactory;
use Elcodi\Component\Cart\Factory\OrderLineFactory;
use Elcodi\Component\Cart\Factory\OrderLineHistoryFactory;

/**
 * Class OrderFactoryTest
 */
class OrderFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test object creation
     *
     * @group order
     */
    public function testCreate()
    {
        $orderLineHistoryFactory = new OrderLineHistoryFactory();
        $orderLineHistoryFactory
            ->setEntityNamespace('Elcodi\Component\Cart\Entity\OrderLineHistory');

        $orderLineFactory = new OrderLineFactory();
        $orderLineFactory
            ->setOrderLineHistoryFactory($orderLineHistoryFactory)
            ->setInitialOrderHistoryState('new')
            ->setEntityNamespace('Elcodi\Component\Cart\Entity\OrderLine');

        $orderLine = $orderLineFactory->create();

        $orderHistoryFactory = new OrderHistoryFactory();
        $orderHistoryFactory
            ->setEntityNamespace('Elcodi\Component\Cart\Entity\OrderHistory');

        $orderFactory = new OrderFactory();
        $orderFactory
            ->setOrderHistoryFactory($orderHistoryFactory)
            ->setInitialOrderHistoryState('new')
            ->setEntityNamespace('Elcodi\Component\Cart\Entity\Order');

        $order = $orderFactory->create();
        $order->addOrderLine($orderLine);

        $this->assertCount(
            1,
            $order->getOrderHistories()
        );

        $this->assertInstanceOf(
            'Elcodi\Component\Cart\Entity\Interfaces\OrderHistoryInterface',
            $order->getOrderHistories()->first()
        );

        $this->assertEquals(
            'new',
            $order->getOrderHistories()->first()->getState()
        );

        $this->assertInstanceOf(
            'Elcodi\Component\Cart\Entity\Interfaces\OrderHistoryInterface',
            $order->getLastOrderHistory()
        );

        $this->assertSame(
            $order->getOrderHistories()->first(),
            $order->getLastOrderHistory()
        );

        $this->assertCount(
            1,
            $order->getOrderLines()
        );

        $orderLine = $order->getOrderLines()->first();

        $this->assertCount(
            1,
            $orderLine->getOrderLineHistories()
        );

        $this->assertInstanceOf(
            'Elcodi\Component\Cart\Entity\Interfaces\OrderLineHistoryInterface',
            $orderLine->getOrderLineHistories()->first()
        );

        $this->assertEquals(
            $orderLine->getOrderLineHistories()->first()->getState(),
            'new'
        );

        $this->assertInstanceOf(
            'Elcodi\Component\Cart\Entity\Interfaces\OrderLineHistoryInterface',
            $orderLine->getLastOrderLineHistory()
        );

        $this->assertSame(
            $orderLine->getOrderLineHistories()->first(),
            $orderLine->getLastOrderLineHistory()
        );
    }
}
