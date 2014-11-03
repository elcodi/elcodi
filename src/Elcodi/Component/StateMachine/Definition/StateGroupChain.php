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
 * Class StateGroupChain
 */
class StateGroupChain
{
    /**
     * @var array
     *
     * StateGroups
     */
    protected $stateGroups;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->stateGroups = array();
    }

    /**
     * Add stateGroup
     *
     * @param StateGroup $stateGroup Add stateGroup
     *
     * @return $this self Object
     */
    public function addStateGroup(StateGroup $stateGroup)
    {
        $this->stateGroups[$stateGroup->getName()] = $stateGroup;

        return $this;
    }

    /**
     * get stateGroups
     *
     * @return StateGroup[] StateGroups
     */
    public function getStateGroups()
    {
        return $this->stateGroups;
    }

    /**
     * has stateGroup
     *
     * @param string $stateGroupName StateGroup name
     *
     * @return boolean Has stateGroup
     */
    public function hasStateGroup($stateGroupName)
    {
        return isset($this->stateGroups[$stateGroupName]);
    }

    /**
     * get stateGroup
     *
     * @param string $stateGroupName StateGroup name
     *
     * @return StateGroup StateGroup
     */
    public function getStateGroup($stateGroupName)
    {
        return $this->stateGroups[$stateGroupName];
    }
}
