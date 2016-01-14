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

namespace Elcodi\Component\StateTransitionMachine\Event;

use stdClass;
use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;

/**
 * Class TransitionEvent.
 */
final class TransitionEvent extends Event
{
    /**
     * @var stdClass
     *
     * Object
     */
    private $object;

    /**
     * @var StateLineStack
     *
     * State line stack
     */
    private $stateLineStack;

    /**
     * @var Transition
     *
     * Transition
     */
    private $transition;

    /**
     * Construct.
     *
     * @param stdClass       $object         Object
     * @param StateLineStack $stateLineStack State line stack
     * @param Transition     $transition     Transition
     */
    public function __construct(
        $object,
        StateLineStack $stateLineStack,
        Transition $transition
    ) {
        $this->object = $object;
        $this->stateLineStack = $stateLineStack;
        $this->transition = $transition;
    }

    /**
     * Get Object.
     *
     * @return stdClass Object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Get StateLine Stack.
     *
     * @return StateLineStack
     */
    public function getStateLineStack()
    {
        return $this->stateLineStack;
    }

    /**
     * get transition.
     *
     * @return Transition Transition
     */
    public function getTransition()
    {
        return $this->transition;
    }

    /**
     * Create new object.
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
    ) {
        return new self(
            $object,
            $stateLineStack,
            $transition
        );
    }
}
