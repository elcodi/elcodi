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
use Elcodi\CartBundle\Factory\OrderFactory;
use Elcodi\CartBundle\Factory\OrderHistoryFactory;
use Elcodi\CartBundle\Factory\OrderLineFactory;
use Elcodi\CartBundle\Factory\OrderLineHistoryFactory;
use Elcodi\CartBundle\Services\OrderLineManager;
use Elcodi\CartBundle\Exception\OrderLineStateChangeNotReachableException;

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

        $orderLineFactory = new OrderLineFactory();
        $orderLineFactory->setEntityNamespace('Elcodi\CartBundle\Entity\OrderLine');

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
            $orderLineFactory,
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
     * Test invalid state changes
     *
     * Invalid state transitions must throw an exception
     *
     * @expectedException \Elcodi\CartBundle\Exception\OrderLineStateChangeNotReachableException
     */
    public function testCheckChangeToState()
    {
        // new to accepted
        $this->assertTrue($this->orderLineManager->checkChangeToState($this->orderLine, 'accepted'));

        // new to problem
        $this->assertTrue($this->orderLineManager->checkChangeToState($this->orderLine, 'problem'));

        // new to ready.ship
        $this->assertTrue($this->orderLineManager->checkChangeToState($this->orderLine, 'ready.ship'));

        // 'new' to 'shipped'
        $this->assertTrue($this->orderLineManager->checkChangeToState($this->orderLine, 'shipped'));

    }

    /*
     * Test valid state changes.
     *
     * Change to the same state is considered valid, but returns false
     */
    public function testPassCheckChangeToState()
    {
        // SetUp method let last history state for $this->orderline to 'new'
        $this->assertFalse($this->orderLineManager->checkChangeToState($this->orderLine, 'new'));

        // 'new' to 'accepted'
        $this->assertTrue($this->orderLineManager->checkChangeToState($this->orderLine, 'accepted'));

        $this->orderLine->getOrderLineHistories()->last()->setState('accepted');

        // 'accepted' to 'ready.ship'
        $this->assertTrue($this->orderLineManager->checkChangeToState($this->orderLine, 'ready.ship'));
        // 'accepted' to 'problem'
        $this->assertTrue($this->orderLineManager->checkChangeToState($this->orderLine, 'problem'));
        // 'accepted' to 'accepted'
        $this->assertTrue($this->orderLineManager->checkChangeToState($this->orderLine, 'accepted'));

    }
}
