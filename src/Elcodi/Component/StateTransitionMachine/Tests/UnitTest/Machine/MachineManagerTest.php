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

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Machine;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\StateTransitionMachine\Entity\StateLine;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\AbstractStateTransitionTest;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\Order;

/**
 * Class MachineManagerTest.
 */
class MachineManagerTest extends AbstractStateTransitionTest
{
    /**
     * Test initialize.
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\ObjectAlreadyInitializedException
     */
    public function testInitializeNotEmpty()
    {
        $machineManager = $this->getMachineManager();

        $order = new Order();
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        $order->setStateLineStack($stateLineStack);

        $stateLineStack->addStateLine(new StateLine());
        $machineManager->initialize(
            $order,
            $stateLineStack,
            ''
        );
    }

    /**
     * Test initialize.
     */
    public function testInitializeEmpty()
    {
        $machineManager = $this->getMachineManager();

        $order = new Order();
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        $order->setStateLineStack($stateLineStack);

        $stateLineStack = $machineManager->initialize(
            $order,
            $stateLineStack,
            ''
        );

        $this->assertEquals('unpaid', $stateLineStack->getLastStateLine()->getName());
        $this->assertCount(1, $stateLineStack->getStateLines());
    }

    /**
     * Test make transition with a non-initialized object.
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\ObjectNotInitializedException
     */
    public function testMakeTransitionNonInitialized()
    {
        $machineManager = $this->getMachineManager();

        $order = new Order();
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        $order->setStateLineStack($stateLineStack);

        $machineManager->transition(
            $order,
            $stateLineStack,
            'pay',
            ''
        );
    }

    /**
     * Test make transition with an initialized object.
     */
    public function testMakeTransitionInitialized()
    {
        $machineManager = $this->getMachineManager();

        $order = new Order();
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        $order->setStateLineStack($stateLineStack);

        $stateLineStack = $machineManager->initialize(
            $order,
            $stateLineStack,
            ''
        );

        $stateLineStack = $machineManager->transition(
            $order,
            $stateLineStack,
            'pay',
            ''
        );

        $this->assertEquals('paid', $stateLineStack->getLastStateLine()->getName());
        $this->assertEquals('paid', $stateLineStack->getStateLines()->last()->getName());
    }

    /**
     * Test make transition with a non-initialized object.
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\ObjectNotInitializedException
     */
    public function testReachStateNonInitialized()
    {
        $machineManager = $this->getMachineManager();

        $order = new Order();
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        $order->setStateLineStack($stateLineStack);

        $machineManager->reachState(
            $order,
            $stateLineStack,
            'paid',
            ''
        );
    }

    /**
     * Test make transition with an initialized object.
     */
    public function testReachStateInitialized()
    {
        $machineManager = $this->getMachineManager();

        $order = new Order();
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        $order->setStateLineStack($stateLineStack);
        $stateLineStack = $machineManager->initialize(
            $order,
            $stateLineStack,
            ''
        );
        $order->setStateLineStack($stateLineStack);

        $stateLineStack = $machineManager->reachState(
            $order,
            $stateLineStack,
            'paid',
            ''
        );

        $this->assertEquals('paid', $stateLineStack->getLastStateLine()->getName());
        $this->assertEquals('paid', $stateLineStack->getStateLines()->last()->getName());
    }
}
