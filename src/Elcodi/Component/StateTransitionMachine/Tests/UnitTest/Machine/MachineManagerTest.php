<?php

/*
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

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Machine;

use Elcodi\Component\StateTransitionMachine\Entity\StateLine;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\AbstractStateTransitionTest;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\Order;

/**
 * Class MachineManagerTest
 */
class MachineManagerTest extends AbstractStateTransitionTest
{
    /**
     * Test initialize
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\ObjectAlreadyInitializedException
     */
    public function testInitializeNotEmpty()
    {
        $machineManager = $this->getMachineManager(0);

        $order = new Order();
        $stateLine = new StateLine();
        $order->addStateLine($stateLine);
        $machineManager->initialize($order, '');
    }

    /**
     * Test initialize
     */
    public function testInitializeEmpty()
    {
        $machineManager = $this->getMachineManager(1);

        $order = new Order();
        $stateLine = $machineManager->initialize($order, '');
        $this->assertEquals('unpaid', $stateLine->getName());
    }

    /**
     * Test make transition with a non-initialized object
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\ObjectNotInitializedException
     */
    public function testMakeTransitionNonInitialized()
    {
        $machineManager = $this->getMachineManager(0);

        $order = new Order();
        $machineManager->transition($order, 'pay', '');
    }

    /**
     * Test make transition with an initialized object
     */
    public function testMakeTransitionInitialized()
    {
        $machineManager = $this->getMachineManager(4);

        $order = new Order();
        $machineManager->initialize($order, '');
        $transition = $machineManager->transition($order, 'pay', '');

        $this->assertEquals('pay', $transition->getName());
        $this->assertEquals('paid', $transition->getFinal()->getName());
        $this->assertEquals('paid', $order->getLastStateLine()->getName());
        $this->assertEquals('paid', $order->getStateLines()->last()->getName());
    }

    /**
     * Test make transition with a non-initialized object
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\ObjectNotInitializedException
     */
    public function testReachStateNonInitialized()
    {
        $machineManager = $this->getMachineManager(0);

        $order = new Order();
        $machineManager->reachState($order, 'paid', '');
    }

    /**
     * Test make transition with an initialized object
     */
    public function testReachStateInitialized()
    {
        $machineManager = $this->getMachineManager(4);

        $order = new Order();
        $machineManager->initialize($order, '');
        $transition = $machineManager->reachState($order, 'paid', '');

        $this->assertEquals('pay', $transition->getName());
        $this->assertEquals('paid', $transition->getFinal()->getName());
        $this->assertEquals('paid', $order->getLastStateLine()->getName());
        $this->assertEquals('paid', $order->getStateLines()->last()->getName());
    }
}
