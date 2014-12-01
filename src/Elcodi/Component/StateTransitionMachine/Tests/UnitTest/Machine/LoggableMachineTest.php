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

use Elcodi\Component\StateTransitionMachine\Machine\LoggableMachine;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\MachineMockery;
use PHPUnit_Framework_TestCase;

/**
 * Class LoggableMachineTest
 */
class LoggableMachineTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test log
     */
    public function testLog()
    {
        $machine = $this->getMock('Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface');
        $machine
            ->expects($this->any())
            ->method('go')
            ->will($this->returnValue(MachineMockery::getTransition()));

        $logger = $this->getMock('Psr\Log\LoggerInterface');
        $logger
            ->expects($this->atLeastOnce())
            ->method('info');

        $loggableMachine = new LoggableMachine(
            $machine,
            $logger
        );

        $loggableMachine->go('start', 'transition');
    }
}
