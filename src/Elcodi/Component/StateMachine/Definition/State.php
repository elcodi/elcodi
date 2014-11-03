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

namespace Elcodi\Component\StateMachine\Definition;

/**
 * Class State
 */
class State
{
    /**
     * @var string
     *
     * name
     */
    public $name;

    /**
     * @var StateChain
     *
     * State chain
     */
    protected $nextStates;

    /**
     * construct method
     *
     * @param string     $name       State name
     * @param StateChain $nextStates Next states
     */
    public function __construct($name, StateChain $nextStates)
    {
        $this->name = $name;
        $this->nextStates = $nextStates;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get NextStates
     *
     * @return StateChain NextStates
     */
    public function getNextStates()
    {
        return $this->nextStates;
    }
}
