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

namespace Elcodi\Component\StateMachine\Tests\Machine;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\StateMachine\Machine\Machine;
use Elcodi\Component\StateMachine\Tests\Fixtures\Order;

/**
 * Class MachineTest
 */
class MachineTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the machine built
     *
     * $states = array(
     *      'state1' => array('state2'),
     *      'state2' => array('state3'),
     *      'state3' => array('state1', 'state4'),
     * );
     * $machine = new Machine($states);
     *
     * @dataProvider dataMachineCompileOk
     */
    public function testMachineCompileOk($configuration, $pointOfEntry)
    {
        new Machine('id', $configuration, $pointOfEntry);
    }

    /**
     * data for testMachineCompileOk
     */
    public function dataMachineCompileOk()
    {
        return [
            [['state1'], 'state1'],
            [['state1' => 'state1'], 'state1'],
            [
                [
                    'state1' => ['state2'],
                    'state2' => ['state3'],
                    'state3' => ['state1', 'state4'],
                    'state4' => ['state2', 'state4'],
                    'state5' => [],
                ], 'state1'
            ]
        ];
    }

    /**
     * Test the machine built with bad configuration
     *
     * @dataProvider dataMachineCompileFail
     * @expectedException \Elcodi\Component\StateMachine\Exception\StateNotValidException
     */
    public function testMachineCompileFail($configuration, $pointOfEntry)
    {
        $machine = new Machine('id', $configuration, $pointOfEntry);
        $machine->compile();
    }

    /**
     * data for testMachineCompileFail
     */
    public function dataMachineCompileFail()
    {
        return [
            [
                [
                    'state1' => ['state2'],
                ], 'state1'
            ],
            [
                [
                    'state1' => [],
                    '' => [],
                ], 'state1'
            ],
            [
                [
                    'state1' => [],
                    1 => [],
                ], 'state1'
            ],
            [
                [
                    'state1' => [false],
                ], 'state1'
            ],
            [
                [
                    'state1' => [null],
                ], 'state1'
            ],
            [
                [
                    'state1' => [true],
                ], 'state1'
            ],
            [
                [
                    'state1' => [''],
                ], 'state1'
            ],
            [
                [
                    '' => ['state1'],
                ], ''
            ]
        ];
    }

    /**
     * Test that a machine can only be compiled once
     *
     * @expectedException \Elcodi\Component\StateMachine\Exception\MachineAlreadyCompiledException
     */
    public function testMachineAlreadyCompiled()
    {
        $machine = new Machine('id', ['state1' => ['state1']], 'state1');
        $machine->compile();
        $machine->compile();
    }

    /**
     * Test invalid point of entry
     *
     * @dataProvider dataInvalidPointOfEntry
     * @expectedException \Elcodi\Component\StateMachine\Exception\InvalidPointOfEntryException
     */
    public function testInvalidPointOfEntry($pointOfEntry)
    {
        $machine = new Machine('id', ['state1' => ['state1']], $pointOfEntry);
        $machine->compile();
    }

    /**
     * data for testInvalidPointOfEntry
     */
    public function dataInvalidPointOfEntry()
    {
        return [
            ['state2'],
            [null],
            [false],
            [true],
            [''],
        ];
    }

    /**
     * Test allow cycles false
     *
     * @expectedException \Elcodi\Component\StateMachine\Exception\CyclesNotAllowedException
     */
    public function testAllowCyclesFalse()
    {
        $machine = new Machine('id', [
            'state1' => ['state2'],
            'state2' => ['state1'],
        ], 'state1');

        $machine->allowCycles(false);
        $machine->compile();
    }

    /**
     * Test can change
     */
    public function testCanChange()
    {
        $machine = new Machine('machine', [
            'state1' => ['state2'],
            'state2' => ['state3'],
            'state3' => ['state1', 'state4'],
            'state4' => ['state2', 'state4'],
            'state5' => [],
        ], 'state1');
        $machine->compile();

        $order = new Order();
        $this->assertTrue($machine->canChange($order, 'state1'));
        $this->assertFalse($machine->canChange($order, 'state2'));
    }

    /**
     * Test can change
     *
     * @expectedException \Elcodi\Component\StateMachine\Exception\StateNotValidException
     */
    public function testCanChangeInvalidStateName()
    {
        $machine = new Machine('machine', [
            'state1' => ['state2']
        ], 'state1');
        $machine->compile();

        $order = new Order();
        $this->assertTrue($machine->canChange($order, 'state3'));
    }

    /**
     * Test usage of can method without compiling
     *
     * @expectedException \Elcodi\Component\StateMachine\Exception\MachineNeedsCompilationException
     */
    public function testCanChangeWithoutCompile()
    {
        $machine = new Machine('id', ['' => ''], '');
        $order = new Order();
        $machine->canChange($order, '');
    }

    /**
     * Test add state
     */
    public function testAddState()
    {
        $machine = new Machine('machine', [
            'state1' => ['state2'],
            'state2' => ['state3'],
            'state3' => ['state1', 'state4'],
            'state4' => ['state2', 'state4', 'state5'],
            'state5' => [],
        ], 'state1');
        $machine->compile();

        $order = new Order();
        $this->assertFalse($machine->addState($order, 'state5', 'description'));
        $this->assertTrue($machine->addState($order, 'state1', 'description'));
        $this->assertTrue($machine->addState($order, 'state2', 'description'));
        $this->assertFalse($machine->addState($order, 'state2', 'description'));
        $this->assertTrue($machine->addState($order, 'state3', 'description'));
        $this->assertTrue($machine->addState($order, 'state4', 'description'));
        $this->assertTrue($machine->addState($order, 'state2', 'description'));
        $this->assertTrue($machine->addState($order, 'state3', 'description'));
        $this->assertTrue($machine->addState($order, 'state1', 'description'));
        $this->assertTrue($machine->addState($order, 'state2', 'description'));
        $this->assertTrue($machine->addState($order, 'state3', 'description'));
        $this->assertTrue($machine->addState($order, 'state4', 'description'));
        $this->assertTrue($machine->addState($order, 'state5', 'description'));

        $this->assertCount(11, $order->stateLines);
    }

    /**
     * Test add state with invalid state name
     *
     * @expectedException \Elcodi\Component\StateMachine\Exception\StateNotValidException
     */
    public function testAddStateInvalidStateName()
    {
        $machine = new Machine('machine', [
            'state1' => ['state1']
        ], 'state1');
        $machine->compile();

        $order = new Order();
        $machine->addState($order, 'state3', 'description');
    }

    /**
     * Test usage of can method without compiling
     *
     * @expectedException \Elcodi\Component\StateMachine\Exception\MachineNeedsCompilationException
     */
    public function testAddStateWithoutCompile()
    {
        $machine = new Machine('id', ['' => ''], '');
        $order = new Order();
        $machine->addState($order, '', '');
    }

    /**
     * Test state point
     */
    public function testBelongsTo()
    {
        $machine = new Machine('machine', [
            'state1' => ['state2'],
            'state2' => ['state3'],
            'state3' => ['state1', 'state4'],
            'state4' => ['state2', 'state4', 'state5'],
            'state5' => [],
        ], 'state1');

        $machine->addStatGroup('specific_status', array(
            'state4', 'state5',
        ));

        $machine->compile();
        $order = new Order();

        $machine->addState($order, 'state1', 'description');
        $machine->addState($order, 'state2', 'description');
        $this->assertFalse($machine->belongsTo($order, 'specific_status'));
        $this->assertFalse($machine->belongsTo($order, 'non_existing_status'));
        $machine->addState($order, 'state3', 'description');
        $machine->addState($order, 'state4', 'description');
        $this->assertTrue($machine->belongsTo($order, 'specific_status'));
        $machine->addState($order, 'state5', 'description');
        $this->assertTrue($machine->belongsTo($order, 'specific_status'));
    }

    /**
     * Test state point
     *
     * @expectedException \Elcodi\Component\StateMachine\Exception\StateNotValidException
     */
    public function testBelongsToInvalidState()
    {
        $machine = new Machine('machine', [
            'state1' => ['state2'],
            'state2' => ['state3'],
            'state3' => ['state1', 'state4'],
            'state4' => ['state2', 'state4', 'state5'],
            'state5' => [],
        ], 'state1');

        $machine->addStatGroup('specific_status', array(
            'state4', 'state9',
        ));

        $machine->compile();
    }

    /**
     * Test has state
     */
    public function testHasState()
    {
        $machine = new Machine('machine', [
            'state1' => ['state2'],
            'state2' => [],
        ], 'state1');

        $machine->compile();
        $this->assertTrue($machine->hasState('state1'));
        $this->assertFalse($machine->hasState('state3'));
    }

    /**
     * Test has state group
     */
    public function testHasStateGroup()
    {
        $machine = new Machine('machine', [
            'state1' => ['state2'],
            'state2' => [],
        ], 'state1');

        $machine->addStatGroup('specific_status', array(
            'state1',
        ));

        $machine->compile();
        $this->assertTrue($machine->hasStateGroup('specific_status'));
        $this->assertFalse($machine->hasState('non_existing_status'));
    }
}
