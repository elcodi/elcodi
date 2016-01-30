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

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures;

use PHPUnit_Framework_TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\StateTransitionMachine\Definition\State;
use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Definition\TransitionChain;
use Elcodi\Component\StateTransitionMachine\Factory\StateLineFactory;
use Elcodi\Component\StateTransitionMachine\Machine\Machine;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;

/**
 * Class MachineMockery.
 */
abstract class AbstractStateTransitionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Return compiled machine.
     *
     * @return Machine Machine instance
     */
    public function getMachine()
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
     * Return transition.
     *
     * @return Transition transition
     */
    public function getTransition()
    {
        $transition = new Transition(
            'pay',
            new State('unpaid'),
            new State('paid')
        );

        return $transition;
    }

    /**
     * Return MachineManager.
     *
     * @param string $stateLineNamespace StateLine Entity Namespace
     *
     * @return MachineManager Machine Manager
     */
    public function getMachineManager($stateLineNamespace = 'Elcodi\Component\StateTransitionMachine\Entity\StateLine')
    {
        $machine = $this->getMachine();
        $stateLineFactory = new StateLineFactory();
        $stateLineFactory->setEntityNamespace($stateLineNamespace);
        $stateLineFactory->setDateTimeFactory(new DateTimeFactory());

        /**
         * @var EventDispatcherInterface $eventDispatcher
         */
        $eventDispatcher = $this->getMock('Elcodi\Component\StateTransitionMachine\EventDispatcher\MachineEventDispatcher', [], [], '', false);

        $machineManager = new MachineManager(
            $machine,
            $eventDispatcher,
            $stateLineFactory
        );

        return $machineManager;
    }
}
