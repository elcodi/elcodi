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

namespace Elcodi\Component\StateTransitionMachine;

/**
 * Class ElcodiStateTransitionMachineEvents.
 */
class ElcodiStateTransitionMachineEvents
{
    /**
     * This event is fired each time an object is initialized into the machine.
     *
     * event.name : state_machine.{machine_id}.initialization
     * event.class : InitializationEvent
     */
    const INITIALIZATION = 'state_machine.{machine_id}.initialization';

    /**
     * This event is fired each time a transition is done from a state.
     *
     * event.name : state_machine.{machine_id}.transition_from_{state_name}
     * event.class : TransitionEvent
     */
    const TRANSITION_FROM_STATE = 'state_machine.{machine_id}.transition_from_{state_name}';

    /**
     * This event is fired each time a transition is done.
     *
     * event.name : state_machine.{machine_id}.{transition_name}
     * event.class : TransitionEvent
     */
    const TRANSITION = 'state_machine.{machine_id}.transition_{transition_name}';

    /**
     * This event is fired each time a transition is done to a state.
     *
     * event.name : state_machine.{machine_id}.transition_to_{state_name}
     * event.class : TransitionEvent
     */
    const TRANSITION_TO_STATE = 'state_machine.{machine_id}.transition_to_{state_name}';

    /**
     * This event is fired each time a transition is done.
     *
     * event.name : state_machine.{machine_id}.{transition_name}
     * event.class : TransitionEvent
     */
    const ALL_TRANSITIONS = 'state_machine.transition';
}
