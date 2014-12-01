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

namespace Elcodi\Component\StateTransitionMachine\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;

/**
 * Class TransitionEvent
 */
class TransitionEvent extends Event
{
    /**
     * @var Transition
     *
     * Transition
     */
    protected $transition;

    /**
     * Construct
     *
     * @param Transition $transition Transition
     */
    public function __construct(Transition $transition)
    {
        $this->transition = $transition;
    }

    /**
     * get transition
     *
     * @return Transition Transition
     */
    public function getTransition()
    {
        return $this->transition;
    }
}
