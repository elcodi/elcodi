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
use Elcodi\Component\StateTransitionMachine\Definition\TransitionChain;
use Elcodi\Component\StateTransitionMachine\Exception\StateNotReachableException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;

/**
 * Class Machine.
 */
class Machine implements MachineInterface
{
    /**
     * @var int
     *
     * Machine id
     */
    private $machineId;

    /**
     * @var TransitionChain
     *
     * Transition chain
     */
    private $transitionChain;

    /**
     * @var string
     *
     * Point of entry
     */
    private $pointOfEntry;

    /**
     * @param int             $machineId       Machine id
     * @param TransitionChain $transitionChain Transition Chain
     * @param string          $pointOfEntry    Point of entry
     */
    public function __construct(
        $machineId,
        TransitionChain $transitionChain,
        $pointOfEntry
    ) {
        $this->machineId = $machineId;
        $this->transitionChain = $transitionChain;
        $this->pointOfEntry = $pointOfEntry;
    }

    /**
     * Get machine id.
     *
     * @return string Machine identifier
     */
    public function getId()
    {
        return $this->machineId;
    }

    /**
     * Get point of entry.
     *
     * @return string Point of entry
     */
    public function getPointOfEntry()
    {
        return $this->pointOfEntry;
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
        if (!$this->transitionChain->hasTransition($transitionName)) {
            throw new TransitionNotValidException($transitionName);
        }

        $transition = $this
            ->transitionChain
            ->getTransitionByStartingStateAndTransitionName(
                $startStateName,
                $transitionName
            );

        if (!($transition instanceof Transition)) {
            throw new TransitionNotAccessibleException();
        }

        return $transition;
    }

    /**
     * Reaches a state given a start state.
     *
     * @param string $startStateName Start state name
     * @param string $finalStateName Final state name
     *
     * @return Transition Transition created
     *
     * @throws StateNotReachableException State is not reachable
     */
    public function reachState(
        $startStateName,
        $finalStateName
    ) {
        $transition = $this
            ->transitionChain
            ->getTransitionByStartingStateAndFinalState(
                $startStateName,
                $finalStateName
            );

        if (!($transition instanceof Transition)) {
            throw new StateNotReachableException();
        }

        return $transition;
    }

    /**
     * Get available states given a start state.
     *
     * @param string $startStateName Start state name
     *
     * @return array Set of states
     */
    public function getAvailableStates($startStateName)
    {
        return array_filter(
            $this->transitionChain->getTransitions(),
            function (Transition $transition) use ($startStateName) {
                return
                    $transition->getStart()->getName() === $startStateName;
            }
        );
    }
}
