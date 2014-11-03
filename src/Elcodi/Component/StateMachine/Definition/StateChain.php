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
 * Class StateChain
 */
class StateChain
{
    /**
     * @var array
     *
     * States
     */
    protected $states;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->states = array();
    }

    /**
     * Add state
     *
     * @param State $state Add state
     *
     * @return $this self Object
     */
    public function addState(State $state)
    {
        $this->states[$state->getName()] = $state;

        return $this;
    }

    /**
     * get states
     *
     * @return State[] States
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * has state
     *
     * @param string $stateName State name
     *
     * @return boolean Has state
     */
    public function hasState($stateName)
    {
        return isset($this->states[$stateName]);
    }

    /**
     * get state
     *
     * @param string $stateName State name
     *
     * @return State State
     */
    public function getState($stateName)
    {
        return $this->states[$stateName];
    }
}
