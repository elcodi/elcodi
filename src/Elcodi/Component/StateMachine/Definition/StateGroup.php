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
 * Class StateGroup
 */
class StateGroup
{
    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var StateChain
     *
     * State chain
     */
    protected $stateChain;

    /**
     * Constructor
     *
     * @param string     $name       Name
     * @param StateChain $stateChain State chain
     */
    public function __construct($name, StateChain $stateChain)
    {
        $this->name = $name;
        $this->stateChain = $stateChain;
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
     * Get StateChain
     *
     * @return StateChain StateChain
     */
    public function getStateChain()
    {
        return $this->stateChain;
    }
}
