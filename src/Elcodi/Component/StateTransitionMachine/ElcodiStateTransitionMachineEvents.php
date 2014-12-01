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

namespace Elcodi\Component\StateTransitionMachine;

/**
 * Class ElcodiStateTransitionMachineEvents
 */
class ElcodiStateTransitionMachineEvents
{
    /**
     * This event is fired each time a transition is done from a state
     *
     * event.name : state_machine.from_{state_name}
     * event.class : FromStateEvent
     */
    const FROM_STATE = 'state_machine.from_{state_name}';

    /**
     * This event is fired each time a transition is done
     *
     * event.name : state_machine.{transition_name}
     * event.class : TransitionEvent
     */
    const TRANSITION = 'state_machine.{transition_name}';

    /**
     * This event is fired each time a transition is done to a state
     *
     * event.name : state_machine.to_{state_name}
     * event.class : ToStateEvent
     */
    const TO_STATE = 'state_machine.to_{state_name}';
}
