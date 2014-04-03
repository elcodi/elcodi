<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Tests\UnitTest\Factory;

use PHPUnit_Framework_TestCase;

use Elcodi\CartBundle\Factory\OrderFactory;
use Elcodi\CartBundle\Factory\OrderHistoryFactory;
use Elcodi\CartBundle\Factory\OrderLineFactory;
use Elcodi\CartBundle\Factory\OrderLineHistoryFactory;

/**
 * Class OrderFactoryTest
 */
class OrderFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test object creation
     */
    public function testCreate()
    {
        $orderLineHistoryFactory = new OrderLineHistoryFactory();
        $orderLineHistoryFactory->setEntityNamespace('Elcodi\CartBundle\Entity\OrderLineHistory');

        $orderLineFactory = new OrderLineFactory();
        $orderLineFactory
            ->setOrderLineHistoryFactory($orderLineHistoryFactory)
            ->setInitialOrderHistoryState('new')
            ->setEntityNamespace('Elcodi\CartBundle\Entity\OrderLine');
        $orderLine = $orderLineFactory->create();

        $orderHistoryFactory = new OrderHistoryFactory();
        $orderHistoryFactory->setEntityNamespace('Elcodi\CartBundle\Entity\OrderHistory');

        $orderFactory = new OrderFactory();
        $orderFactory
            ->setOrderHistoryFactory($orderHistoryFactory)
            ->setInitialOrderHistoryState('new')
            ->setEntityNamespace('Elcodi\CartBundle\Entity\Order');

        $order = $orderFactory->create();
        $order->addOrderLine($orderLine);

        $this->assertCount(1, $order->getOrderHistories());
        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface', $order->getOrderHistories()->first());
        $this->assertEquals('new', $order->getOrderHistories()->first()->getState());
        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface', $order->getLastOrderHistory());
        $this->assertSame($order->getOrderHistories()->first(), $order->getLastOrderHistory());

        $this->assertCount(1, $order->getOrderLines());
        $orderLine = $order->getOrderLines()->first();
        $this->assertCount(1, $orderLine->getOrderLineHistories());
        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface', $orderLine->getOrderLineHistories()->first());
        $this->assertEquals('new', $orderLine->getOrderLineHistories()->first()->getState());
        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface', $orderLine->getLastOrderLineHistory());
        $this->assertSame($orderLine->getOrderLineHistories()->first(), $orderLine->getLastOrderLineHistory());
    }
}
