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

use Psr\Log\LoggerInterface;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Exception\StateNotReachableException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;

/**
 * Class LoggableMachine.
 */
class LoggableMachine implements MachineInterface
{
    /**
     * @var MachineInterface
     *
     * Machine
     */
    private $machine;

    /**
     * @var LoggerInterface
     *
     * Logger
     */
    private $logger;

    /**
     * Construct.
     *
     * @param MachineInterface $machine Machine
     * @param LoggerInterface  $logger  Logger
     */
    public function __construct(
        MachineInterface $machine,
        LoggerInterface $logger
    ) {
        $this->machine = $machine;
        $this->logger = $logger;
    }

    /**
     * Get machine id.
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
     * Get point of entry.
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
     * Applies a transition from a state.
     *
     * @param string $startStateName Start state name
     * @param string $transitionName Transition name
     *
     * @return Transition Transition created
     *
     * @throws TransitionNotAccessibleException Transition not accessible
     * @throws TransitionNotValidException      Invalid transition name
     */
    public function transition(
        $startStateName,
        $transitionName
    ) {
        $transition = $this
            ->machine
            ->transition(
                $startStateName,
                $transitionName
            );

        $this->logTransition($transition);

        return $transition;
    }

    /**
     * Reaches a state given a start state.
     *
     * @param string $startStateName Start state name
     * @param string $finalStateName Final state name
     *
     * @return Transition Transition done
     *
     * @throws StateNotReachableException
     */
    public function reachState(
        $startStateName,
        $finalStateName
    ) {
        $transition = $this
            ->machine
            ->reachState(
                $startStateName,
                $finalStateName
            );

        $this->logTransition($transition);

        return $transition;
    }

    /**
     * Log transition.
     *
     * @param Transition $transition Transition to log
     *
     * @return $this Self object
     */
    public function logTransition(Transition $transition)
    {
        $this
            ->logger
            ->info(
                'Transition {transition_name} in machine "{machine_id}" from "{state_from}" to "{state_to}"',
                [
                    'transition_name' => $transition->getName(),
                    'machine_id' => $this->machine->getId(),
                    'state_from' => $transition->getStart()->getName(),
                    'state_to' => $transition->getFinal()->getName(),
                ]
            );
    }
}
