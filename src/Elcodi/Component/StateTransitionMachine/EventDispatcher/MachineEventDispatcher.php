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

namespace Elcodi\Component\StateTransitionMachine\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\ElcodiStateTransitionMachineEvents;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\StateTransitionMachine\Event\InitializationEvent;
use Elcodi\Component\StateTransitionMachine\Event\TransitionEvent;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;

/**
 * Class MachineEventDispatcher.
 */
class MachineEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Throw initialization events.
     *
     * @param MachineInterface $machine        Machine
     * @param mixed            $object         Object
     * @param StateLineStack   $stateLineStack StateLine Stack
     *
     * @return $this Self object
     */
    public function dispatchInitializationEvents(
        MachineInterface $machine,
        $object,
        StateLineStack $stateLineStack
    ) {
        $this
            ->eventDispatcher
            ->dispatch(
                str_replace(
                    '{machine_id}',
                    $machine->getId(),
                    ElcodiStateTransitionMachineEvents::INITIALIZATION
                ),
                InitializationEvent::create(
                    $object,
                    $stateLineStack
                )
            );
    }

    /**
     * Throw transition events.
     *
     * @param MachineInterface $machine        Machine
     * @param mixed            $object         Object
     * @param StateLineStack   $stateLineStack StateLine Stack
     * @param Transition       $transition     Transition
     *
     * @return $this Self object
     */
    public function dispatchTransitionEvents(
        MachineInterface $machine,
        $object,
        StateLineStack $stateLineStack,
        Transition $transition
    ) {
        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiStateTransitionMachineEvents::ALL_TRANSITIONS,
                TransitionEvent::create(
                    $object,
                    $stateLineStack,
                    $transition
                )
            );

        $this
            ->eventDispatcher
            ->dispatch(
                str_replace(
                    [
                        '{machine_id}',
                        '{state_name}',
                    ],
                    [
                        $machine->getId(),
                        $transition->getStart()->getName(),
                    ],
                    ElcodiStateTransitionMachineEvents::TRANSITION_FROM_STATE
                ),
                TransitionEvent::create(
                    $object,
                    $stateLineStack,
                    $transition
                )
            );

        $this
            ->eventDispatcher
            ->dispatch(
                str_replace(
                    [
                        '{machine_id}',
                        '{state_name}',
                    ],
                    [
                        $machine->getId(),
                        $transition->getFinal()->getName(),
                    ],
                    ElcodiStateTransitionMachineEvents::TRANSITION_TO_STATE
                ),
                TransitionEvent::create(
                    $object,
                    $stateLineStack,
                    $transition
                )
            );

        $this
            ->eventDispatcher
            ->dispatch(
                str_replace(
                    [
                        '{machine_id}',
                        '{transition_name}',
                    ],
                    [
                        $machine->getId(),
                        $transition->getName(),
                    ],
                    ElcodiStateTransitionMachineEvents::TRANSITION
                ),
                TransitionEvent::create(
                    $object,
                    $stateLineStack,
                    $transition
                )
            );
    }
}
