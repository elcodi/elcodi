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

namespace Elcodi\Component\StateTransitionMachine\Machine;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\StateTransitionMachine\EventDispatcher\MachineEventDispatcher;
use Elcodi\Component\StateTransitionMachine\Exception\ObjectAlreadyInitializedException;
use Elcodi\Component\StateTransitionMachine\Exception\ObjectNotInitializedException;
use Elcodi\Component\StateTransitionMachine\Exception\StateNotReachableException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Factory\StateLineFactory;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;

/**
 * Class MachineManager.
 */
class MachineManager
{
    /**
     * @var MachineInterface
     *
     * Machine
     */
    private $machine;

    /**
     * @var MachineEventDispatcher
     *
     * Machine Event Dispatcher
     */
    private $machineEventDispatcher;

    /**
     * @var StateLineFactory
     *
     * StateLine factory
     */
    private $stateLineFactory;

    /**
     * Construct.
     *
     * @param MachineInterface       $machine                Machine
     * @param MachineEventDispatcher $machineEventDispatcher Event Dispatcher
     * @param StateLineFactory       $stateLineFactory       StateLine Factory
     */
    public function __construct(
        MachineInterface $machine,
        MachineEventDispatcher $machineEventDispatcher,
        StateLineFactory $stateLineFactory
    ) {
        $this->machine = $machine;
        $this->machineEventDispatcher = $machineEventDispatcher;
        $this->stateLineFactory = $stateLineFactory;
    }

    /**
     * Initialize the object into the machine.
     *
     * @param mixed          $object         Object
     * @param StateLineStack $stateLineStack StateLine Stack
     * @param string         $description    Description
     *
     * @return StateLineStack StateLine stack given
     *
     * @throws ObjectAlreadyInitializedException Object already initialized
     */
    public function initialize(
        $object,
        StateLineStack $stateLineStack,
        $description
    ) {
        if ($stateLineStack->getLastStateLine() instanceof StateLineInterface) {
            throw new ObjectAlreadyInitializedException();
        }

        $pointOfEntry = $this
            ->machine
            ->getPointOfEntry();

        $stateLine = $this->createStateLine(
            $pointOfEntry,
            $description
        );

        $stateLineStack->addStateLine($stateLine);

        $this
            ->machineEventDispatcher
            ->dispatchInitializationEvents(
                $this->machine,
                $object,
                $stateLineStack
            );

        return $stateLineStack;
    }

    /**
     * Applies a transition given a object.
     *
     * @param mixed          $object         Object
     * @param StateLineStack $stateLineStack StateLine Stack
     * @param string         $transitionName Transition name
     * @param string         $description    Description
     *
     * @return StateLineStack StateLine stack given
     *
     * @throws TransitionNotAccessibleException Transition not accessible
     * @throws TransitionNotValidException      Invalid transition
     * @throws ObjectNotInitializedException    Object needs to be initialized in machine
     */
    public function transition(
        $object,
        StateLineStack $stateLineStack,
        $transitionName,
        $description = ''
    ) {
        return $this
            ->applyTransitionAction(
                $object,
                $stateLineStack,
                $transitionName,
                $description,
                'transition'
            );
    }

    /**
     * Applies a transition given a object.
     *
     * @param mixed          $object         Object
     * @param StateLineStack $stateLineStack StateLine Stack
     * @param string         $transitionName Transition name
     * @param string         $description    Description
     *
     * @return StateLineStack StateLine stack given
     *
     * @throws StateNotReachableException    State is not reachable
     * @throws ObjectNotInitializedException Object needs to be initialized in machine
     */
    public function reachState(
        $object,
        StateLineStack $stateLineStack,
        $transitionName,
        $description = ''
    ) {
        return $this
            ->applyTransitionAction(
                $object,
                $stateLineStack,
                $transitionName,
                $description,
                'reachState'
            );
    }

    /**
     * Create an state line given its name and description.
     *
     * @param string $name        Name
     * @param string $description Description
     *
     * @return StateLineInterface State Line
     */
    public function createStateLine($name, $description)
    {
        $stateLine = $this
            ->stateLineFactory
            ->create()
            ->setName($name)
            ->setDescription($description);

        return $stateLine;
    }

    /**
     * Applies a transition action given a object and the kind of transition is
     * needed.
     *
     * @param mixed          $object           Object
     * @param StateLineStack $stateLineStack   StateLine Stack
     * @param string         $transitionName   Transition name
     * @param string         $description      Description
     * @param string         $transitionAction Transition Action
     *
     * @return StateLineStack StateLine stack given
     *
     * @throws StateNotReachableException    State is not reachable
     * @throws ObjectNotInitializedException Object needs to be initialized in machine
     */
    private function applyTransitionAction(
        $object,
        StateLineStack $stateLineStack,
        $transitionName,
        $description,
        $transitionAction
    ) {
        $startState = $stateLineStack->getLastStateLine();

        if (!($startState instanceof StateLineInterface)) {
            throw new ObjectNotInitializedException();
        }

        /**
         * @var Transition $transition
         */
        $transition = $this
            ->machine
            ->$transitionAction(
                $startState->getName(),
                $transitionName
            );

        $stateLine = $this->createStateLine(
            $transition->getFinal()->getName(),
            $description
        );

        $stateLineStack->addStateLine($stateLine);

        $this
            ->machineEventDispatcher
            ->dispatchTransitionEvents(
                $this->machine,
                $object,
                $stateLineStack,
                $transition
            );

        return $stateLineStack;
    }
}
