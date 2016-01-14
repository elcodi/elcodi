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

use Elcodi\Component\StateTransitionMachine\Machine\LoggableMachine;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\AbstractStateTransitionTest;

/**
 * Class LoggableMachineTest.
 */
class LoggableMachineTest extends AbstractStateTransitionTest
{
    /**
     * Test log in make transition.
     */
    public function testMakeTransitionLog()
    {
        $machine = $this->getMock('Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface');
        $machine
            ->expects($this->any())
            ->method('transition')
            ->will($this->returnValue($this->getTransition()));

        $logger = $this->getMock('Psr\Log\LoggerInterface');
        $logger
            ->expects($this->atLeastOnce())
            ->method('info');

        $loggableMachine = new LoggableMachine(
            $machine,
            $logger
        );

        $loggableMachine->transition('start', 'transition');
    }

    /**
     * Test log in reach state.
     */
    public function testReachStateLog()
    {
        $machine = $this->getMock('Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface');
        $machine
            ->expects($this->any())
            ->method('reachState')
            ->will($this->returnValue($this->getTransition()));

        $logger = $this->getMock('Psr\Log\LoggerInterface');
        $logger
            ->expects($this->atLeastOnce())
            ->method('info');

        $loggableMachine = new LoggableMachine(
            $machine,
            $logger
        );

        $loggableMachine->reachState('start', 'state');
    }
}
