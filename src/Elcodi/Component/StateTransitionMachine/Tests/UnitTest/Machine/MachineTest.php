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

namespace Elcodi\Component\StateTransitionMachine\Tests\Machine;

use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\MachineMockery;
use PHPUnit_Framework_TestCase;

/**
 * Class MachineTest
 */
class MachineTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test get machine id
     */
    public function testGetId()
    {
        $machine = MachineMockery::getMachine();

        $this->assertEquals('id', $machine->getId());
    }

    /**
     * Test get point of view
     */
    public function testGetPointOfEntry()
    {
        $machine = MachineMockery::getMachine();

        $this->assertEquals('unpaid', $machine->getPointOfEntry());
    }

    /**
     * Test can
     */
    public function testCan()
    {
        $machine = MachineMockery::getMachine();

        $this->assertTrue($machine->can('unpaid', 'pay'));
        $this->assertTrue($machine->can('unpaid', 'revise'));
        $this->assertFalse($machine->can('unpaid', 'ship'));
    }

    /**
     * Test go
     */
    public function testGo()
    {
        $machine = MachineMockery::getMachine();

        $transition = $machine->go('unpaid', 'pay');
        $this->assertInstanceOf('Elcodi\Component\StateTransitionMachine\Definition\Transition', $transition);
        $this->assertEquals('unpaid', $transition->getStart()->getName());
        $this->assertEquals('pay', $transition->getName());
        $this->assertEquals('paid', $transition->getFinal()->getName());
    }
}
