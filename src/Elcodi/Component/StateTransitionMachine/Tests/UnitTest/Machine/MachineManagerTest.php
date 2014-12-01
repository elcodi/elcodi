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
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\MachineMockery;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\Order;
use PHPUnit_Framework_TestCase;

/**
 * Class MachineManagerTest
 */
class MachineManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test initialize
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\ObjectAlreadyInitializedException
     */
    public function testInitializeNotEmpty()
    {
        $machineManager = MachineMockery::getMachineManager();

        $order = new Order();
        $stateLine = new StateLine();
        $order->addStateLine($stateLine);
        $machineManager->initialize($order);
    }

    /**
     * Test initialize
     */
    public function testInitializeEmpty()
    {
        $machineManager = MachineMockery::getMachineManager();

        $order = new Order();
        $stateLine = $machineManager->initialize($order);
        $this->assertEquals('unpaid', $stateLine->getName());
    }

    /**
     * Test can
     */
    public function testCan()
    {
        $machineManager = MachineMockery::getMachineManager();

        $order = new Order();
        $this->assertFalse($machineManager->can($order, 'pay'));

        $machineManager->initialize($order);

        $this->assertFalse($machineManager->can($order, 'ship'));
        $this->assertTrue($machineManager->can($order, 'pay'));
        $this->assertFalse($machineManager->can($order, 'ship'));
    }

    /**
     * Test go with a non-initialized object
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\ObjectNotInitializedException
     */
    public function testGoNonInitialized()
    {
        $machineManager = MachineMockery::getMachineManager();

        $order = new Order();
        $machineManager->go($order, 'ship');
    }

    /**
     * Test go with an initialized object
     */
    public function testGoInitialized()
    {
        $machineManager = MachineMockery::getMachineManager();

        $order = new Order();
        $machineManager->initialize($order);
        $transition = $machineManager->go($order, 'pay');

        $this->assertEquals('pay', $transition->getName());
        $this->assertEquals('paid', $transition->getFinal()->getName());
    }
}
