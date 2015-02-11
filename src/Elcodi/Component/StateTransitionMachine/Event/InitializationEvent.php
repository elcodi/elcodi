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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\StateTransitionMachine\Event;

use StdClass;
use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;

/**
 * Class InitializationEvent
 */
class InitializationEvent extends Event
{
    /**
     * @var StdClass
     *
     * Object
     */
    protected $object;

    /**
     * @var StateLineStack
     *
     * State line stack
     */
    protected $stateLineStack;

    /**
     * Construct
     *
     * @param StdClass       $object         Object
     * @param StateLineStack $stateLineStack State line stack
     */
    public function __construct(
        $object,
        StateLineStack $stateLineStack
    )
    {
        $this->object = $object;
        $this->stateLineStack = $stateLineStack;
    }

    /**
     * Get Object
     *
     * @return StdClass Object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Get StateLine Stack
     *
     * @return StateLineStack
     */
    public function getStateLineStack()
    {
        return $this->stateLineStack;
    }
}
