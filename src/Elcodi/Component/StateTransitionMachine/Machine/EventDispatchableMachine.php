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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\ElcodiStateTransitionMachineEvents;
use Elcodi\Component\StateTransitionMachine\Event\TransitionEvent;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;

/**
 * Class EventDispatchableMachine
 */
class EventDispatchableMachine implements MachineInterface
{
    /**
     * @var MachineInterface
     *
     * Machine
     */
    protected $machine;

    /**
     * @var EventDispatcherInterface
     *
     * Event Dispatcher
     */
    protected $eventDispatcher;

    /**
     * Construct
     *
     * @param MachineInterface         $machine         Machine
     * @param EventDispatcherInterface $eventDispatcher Event Dispatcher
     */
    public function __construct(
        MachineInterface $machine,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->machine = $machine;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get machine id
     *
     * @return string Machine identifier
     */
    public function getId()
    {
        return $this
            ->machine
            ->getId();
    }

    /**
     * Get point of entry
     *
     * @return string Point of entry
     */
    public function getPointOfEntry()
    {
        return $this
            ->machine
            ->getPointOfEntry();
    }

    /**
     * Can apply an transition given a state
     *
     * @param string $fromStateName  From state name
     * @param string $transitionName Transition name
     *
     * @return boolean Can apply transition
     */
    public function can($fromStateName, $transitionName)
    {
        return $this
            ->machine
            ->can(
                $fromStateName,
                $transitionName
            );
    }

    /**
     * Applies an transition given a state
     *
     * @param string $startStateName Start state name
     * @param string $transitionName Transition name
     *
     * @return Transition Transition done
     *
     * @throws TransitionNotAccessibleException Transition not accessible
     * @throws TransitionNotValidException      Invalid transition
     */
    public function go($startStateName, $transitionName)
    {
        $transition = $this
            ->machine
            ->go(
                $startStateName,
                $transitionName
            );

        $this->dispatchTransitionEvents($transition);

        return $transition;
    }

    /**
     * Throw transition events
     *
     * @param Transition $transition Transition
     */
    public function dispatchTransitionEvents(Transition $transition)
    {
        $this
            ->eventDispatcher
            ->dispatch(
                str_replace(
                    '{state_name}',
                    $transition->getStart()->getName(),
                    ElcodiStateTransitionMachineEvents::FROM_STATE
                ),
                new TransitionEvent($transition)
            );

        $this
            ->eventDispatcher
            ->dispatch(
                str_replace(
                    '{state_name}',
                    $transition->getFinal()->getName(),
                    ElcodiStateTransitionMachineEvents::TO_STATE
                ),
                new TransitionEvent($transition)
            );

        $this
            ->eventDispatcher
            ->dispatch(
                str_replace(
                    '{transition_name}',
                    $transition->getName(),
                    ElcodiStateTransitionMachineEvents::TRANSITION
                ),
                new TransitionEvent($transition)
            );
    }
}
