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

namespace Elcodi\Component\StateTransitionMachine\Definition;

/**
 * Class Transition
 */
class Transition
{
    /**
     * @var string
     *
     * name
     */
    protected $name;

    /**
     * @var State
     *
     * Starting state
     */
    protected $start;

    /**
     * @var State
     *
     * Final state
     */
    protected $final;

    /**
     * Construct method
     *
     * @param string $name  Name
     * @param State  $start Starting state
     * @param State  $final Final state
     */
    public function __construct($name, State $start, State $final)
    {
        $this->name = $name;
        $this->start = $start;
        $this->final = $final;
    }

    /**
     * Get Name
     *
     * @return string Transition name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Starting state
     *
     * @return State Starting state
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get Final state
     *
     * @return State Final state
     */
    public function getFinal()
    {
        return $this->final;
    }
}
