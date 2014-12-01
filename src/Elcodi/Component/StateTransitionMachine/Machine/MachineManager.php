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

namespace Elcodi\Component\StateTransitionMachine\Machine;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateableInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Exception\ObjectAlreadyInitializedException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;
use Elcodi\Component\StateTransitionMachine\Exception\ObjectNotInitializedException;
use Elcodi\Component\StateTransitionMachine\Factory\StateLineFactory;

/**
 * Class MachineManager
 */
class MachineManager
{
    /**
     * @var MachineInterface
     *
     * Machine
     */
    protected $machine;

    /**
     * @var StateLineFactory
     *
     * StateLine factory
     */
    protected $stateLineFactory;

    /**
     * Construct
     *
     * @param MachineInterface $machine          Machine
     * @param StateLineFactory $stateLineFactory StateLine Factory
     */
    public function __construct(
        MachineInterface $machine,
        StateLineFactory $stateLineFactory
    )
    {
        $this->machine = $machine;
        $this->stateLineFactory = $stateLineFactory;
    }

    /**
     * Initialize the object into the machine
     *
     * @param StateableInterface $object Object
     *
     * @return StateLineInterface New state applied
     *
     * @throws ObjectAlreadyInitializedException Object already initialized
     */
    public function initialize(StateableInterface $object)
    {
        if ($object->getLastStateLine() instanceof StateLineInterface) {

            throw new ObjectAlreadyInitializedException();
        }

        $pointOfEntry = $this
            ->machine
            ->getPointOfEntry();

        $stateLine = $this
            ->stateLineFactory
            ->create()
            ->setName($pointOfEntry);

        $object->addStateLine($stateLine);

        return $stateLine;
    }

    /**
     * Given a StateableInterface implementation, check if a transition can be
     * applied
     *
     * @param StateableInterface $object         Object
     * @param string             $transitionName Transition name
     *
     * @return boolean Can apply transition to given object
     */
    public function can(StateableInterface $object, $transitionName)
    {
        $startState = $object->getLastStateLine();

        if (!($startState instanceof StateLineInterface)) {
            return false;
        }

        return $this
            ->machine
            ->can(
                $startState->getName(),
                $transitionName
            );
    }

    /**
     * Applies a transition given a object
     *
     * @param StateableInterface $object         Object
     * @param string             $transitionName Transition name
     *
     * @return Transition Transition done
     *
     * @throws TransitionNotAccessibleException Transition not accessible
     * @throws TransitionNotValidException      Invalid transition
     * @throws ObjectNotInitializedException    Object needs to be initialized in machine
     */
    public function go(StateableInterface $object, $transitionName)
    {
        $startState = $object->getLastStateLine();

        if (!($startState instanceof StateLineInterface)) {

            throw new ObjectNotInitializedException();
        }

        return $this
            ->machine
            ->go(
                $startState->getName(),
                $transitionName
            );
    }
}
