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

namespace Elcodi\CartBundle\Tests\UnitTest\Services;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Entity\OrderLineHistory;
use Elcodi\CartBundle\Factory\OrderFactory;
use Elcodi\CartBundle\Factory\OrderHistoryFactory;
use Elcodi\CartBundle\Factory\OrderLineFactory;
use Elcodi\CartBundle\Factory\OrderLineHistoryFactory;
use Elcodi\CartBundle\Services\OrderLineManager;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit_Framework_TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class OrderLineManagerTest
 */
class OrderLineManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var OrderLineInterface
     *
     * OrderLine
     */
    protected $orderLine;

    /**
     * @var OrderLineManager
     *
     * OrderLineManager mock
     */
    protected $orderLineManager;

    /**
     * Set up
     *
     */
    public function setUp()
    {
        /**
         * @var ObjectManager $manager
         * @var EventDispatcherInterface $eventDispatcher
         */
        $manager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $orderLineHistoryFactory = new OrderLineHistoryFactory();
        $orderLineHistoryFactory->setEntityNamespace('Elcodi\CartBundle\Entity\OrderLineHistory');

        $orderHistoryChangesAvailable = [
            'new'       =>  ['accepted'],
            'accepted'  =>  ['ready.ship', 'problem', 'accepted'],
            'problem'   =>  ['accepted'],
            'ready.ship'=>  ['shipped'],
            'shipped'   =>  ['delivered'],
        ];

        $this->orderLineManager = new OrderLineManager(
            $manager,
            $eventDispatcher,
            $orderLineHistoryFactory,
            $orderHistoryChangesAvailable
        );

        $orderLineHistoryFactory = new OrderLineHistoryFactory();
        $orderLineHistoryFactory->setEntityNamespace('Elcodi\CartBundle\Entity\OrderLineHistory');

        $orderLineFactory = new OrderLineFactory();
        $orderLineFactory
            ->setOrderLineHistoryFactory($orderLineHistoryFactory)
            ->setInitialOrderHistoryState('new')
            ->setEntityNamespace('Elcodi\CartBundle\Entity\OrderLine');
        $this->orderLine = $orderLineFactory->create();

        $orderHistoryFactory = new OrderHistoryFactory();
        $orderHistoryFactory->setEntityNamespace('Elcodi\CartBundle\Entity\OrderHistory');

        $orderFactory = new OrderFactory();
        $orderFactory
            ->setOrderHistoryFactory($orderHistoryFactory)
            ->setInitialOrderHistoryState('new')
            ->setEntityNamespace('Elcodi\CartBundle\Entity\Order');

        $this->order = $orderFactory->create();
        $this->order->addOrderLine($this->orderLine);
    }

    /**
     * Test empty order, trying to get a non reachable state
     *
     * @expectedException Elcodi\CartBundle\Exception\OrderLineStateChangeNotReachableException
     */
    public function testEmptyOrderToProblem()
    {
        $this->orderLineManager->toState($this->order, $this->orderLine, 'problem');
    }

    /**
     * Test empty order, trying to get a reachable state
     */
    public function testEmptyOrderToAccepted()
    {
        $this->orderLineManager->toState($this->order, $this->orderLine, 'accepted');
    }

    /**
     * Test empty order, trying to get same state as actual
     *
     * @expectedException Elcodi\CartBundle\Exception\OrderLineStateNoChangeException
     */
    public function testEmptyOrderToNew()
    {
        $this->orderLineManager->toState($this->order, $this->orderLine, 'new');
    }

    /**
     * Test empty order, trying to get to a non existing state
     *
     * @expectedException Elcodi\CartBundle\Exception\OrderLineStateChangeNotReachableException
     */
    public function testEmptyOrderToNotExistingState()
    {
        $this->orderLineManager->toState($this->order, $this->orderLine, 'state.notexists');
    }

    /**
     * Test empty order, trying to get same state as actual, but defined as possible
     */
    public function testEmptyOrderToSame()
    {
        $this->orderLineManager->toState($this->order, $this->orderLine, 'accepted');
        $this->orderLineManager->toState($this->order, $this->orderLine, 'accepted');
    }

    /**
     * Complete state process
     */
    public function testCompleteTestProcess()
    {
        $this->orderLineManager->toState($this->order, $this->orderLine, 'accepted');
        $this->orderLineManager->toState($this->order, $this->orderLine, 'problem');
        $this->orderLineManager->toState($this->order, $this->orderLine, 'accepted');
        $this->orderLineManager->toState($this->order, $this->orderLine, 'ready.ship');
        $this->orderLineManager->toState($this->order, $this->orderLine, 'shipped');
        $this->orderLineManager->toState($this->order, $this->orderLine, 'delivered');
    }
}
