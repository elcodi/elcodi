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

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures;

use Elcodi\Component\StateTransitionMachine\Definition\State;
use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Definition\TransitionChain;
use Elcodi\Component\StateTransitionMachine\Factory\StateLineFactory;
use Elcodi\Component\StateTransitionMachine\Machine\Machine;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;

/**
 * Class MachineMockery
 */
class MachineMockery
{
    /**
     * Return compiled machine
     *
     * @return Machine Machine instance
     */
    public static function getMachine()
    {
        $transitionChain = TransitionChain::create();
        $transitionChain
            ->addTransition(new Transition('pay', new State('unpaid'), new State('paid')))
            ->addTransition(new Transition('revise', new State('unpaid'), new State('revised')))
            ->addTransition(new Transition('ship', new State('revised'), new State('shipped')));

        $machine = new Machine(
            'id',
            $transitionChain,
            'unpaid'
        );

        return $machine;
    }

    /**
     * Return transition
     *
     * @return Transition transition
     */
    public static function getTransition()
    {
        $transition = new Transition(
            'pay',
            new State('unpaid'),
            new State('paid')
        );

        return $transition;
    }

    /**
     * Return MachineManager
     *
     * @return MachineManager Machine Manager
     */
    public static function getMachineManager()
    {
        $machine = MachineMockery::getMachine();
        $stateLineFactory = new StateLineFactory();
        $stateLineFactory->setEntityNamespace('Elcodi\Component\StateTransitionMachine\Entity\StateLine');

        $machineManager = new MachineManager(
            $machine,
            $stateLineFactory
        );

        return $machineManager;
    }
}
