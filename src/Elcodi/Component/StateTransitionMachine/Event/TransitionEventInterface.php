<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\StateTransitionMachine\Event;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;

/**
 * Interface TransitionEventInterface
 */
interface TransitionEventInterface
{
    /**
     * Get Object
     *
     * @return stdClass Object
     */
    public function getObject();

    /**
     * Get StateLine Stack
     *
     * @return StateLineStack
     */
    public function getStateLineStack();

    /**
     * get transition
     *
     * @return Transition Transition
     */
    public function getTransition();

    /**
     * Create new object
     *
     * @param stdClass       $object         Object
     * @param StateLineStack $stateLineStack State line stack
     * @param Transition     $transition     Transition
     *
     * @return self New instance
     */
    public static function create(
        $object,
        StateLineStack $stateLineStack,
        Transition $transition
    );
}
