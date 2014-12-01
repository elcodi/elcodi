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

namespace Elcodi\Component\StateTransitionMachine\Machine\Interfaces;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;

/**
 * Interface MachineInterface
 */
interface MachineInterface
{
    /**
     * Get machine id
     *
     * @return string Machine identifier
     */
    public function getId();

    /**
     * Get point of entry
     *
     * @return string Point of entry
     */
    public function getPointOfEntry();

    /**
     * Can apply an transition given a state
     *
     * @param string $startStateName Start state name
     * @param string $transitionName Transition name
     *
     * @return boolean Can apply transition
     */
    public function can($startStateName, $transitionName);

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
    public function go($startStateName, $transitionName);
}
