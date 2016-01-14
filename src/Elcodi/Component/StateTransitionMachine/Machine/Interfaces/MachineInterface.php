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

namespace Elcodi\Component\StateTransitionMachine\Machine\Interfaces;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Exception\StateNotReachableException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;

/**
 * Interface MachineInterface.
 */
interface MachineInterface
{
    /**
     * Get machine id.
     *
     * @return string Machine identifier
     */
    public function getId();

    /**
     * Get point of entry.
     *
     * @return string Point of entry
     */
    public function getPointOfEntry();

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
    );

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
    );
}
