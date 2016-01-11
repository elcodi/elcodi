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

namespace Elcodi\Component\StateTransitionMachine\Tests\Machine;

use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\AbstractStateTransitionTest;

/**
 * Class MachineTest.
 */
class MachineTest extends AbstractStateTransitionTest
{
    /**
     * Test get machine id.
     */
    public function testGetId()
    {
        $machine = $this->getMachine();

        $this->assertEquals('id', $machine->getId());
    }

    /**
     * Test get point of view.
     */
    public function testGetPointOfEntry()
    {
        $machine = $this->getMachine();

        $this->assertEquals('unpaid', $machine->getPointOfEntry());
    }

    /**
     * Test make transition.
     */
    public function testMakeTransitionOk()
    {
        $machine = $this->getMachine();

        $transition = $machine->transition('unpaid', 'pay');
        $this->assertInstanceOf('Elcodi\Component\StateTransitionMachine\Definition\Transition', $transition);
        $this->assertEquals('unpaid', $transition->getStart()->getName());
        $this->assertEquals('pay', $transition->getName());
        $this->assertEquals('paid', $transition->getFinal()->getName());
    }

    /**
     * Test make transition with exception.
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException
     */
    public function testMakeTransitionException()
    {
        $machine = $this->getMachine();

        $machine->transition('unpaid', 'ship');
    }

    /**
     * Test reach state.
     */
    public function testReachStateOk()
    {
        $machine = $this->getMachine();

        $transition = $machine->reachState('unpaid', 'paid');
        $this->assertInstanceOf('Elcodi\Component\StateTransitionMachine\Definition\Transition', $transition);
        $this->assertEquals('unpaid', $transition->getStart()->getName());
        $this->assertEquals('pay', $transition->getName());
        $this->assertEquals('paid', $transition->getFinal()->getName());
    }

    /**
     * Test reach state with exception.
     *
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\StateNotReachableException
     */
    public function testReachStateException()
    {
        $machine = $this->getMachine();

        $machine->reachState('unpaid', 'shipped');
    }
}
