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

namespace Elcodi\Component\StateTransitionMachine\Definition;

use DateTime;

/**
 * Class Transition.
 */
class Transition
{
    /**
     * @var string
     *
     * name
     */
    private $name;

    /**
     * @var State
     *
     * Starting state
     */
    private $start;

    /**
     * @var State
     *
     * Final state
     */
    private $final;

    /**
     * @var DateTime
     *
     * DateTime of the creation of this transition
     */
    private $createdAt;

    /**
     * Construct method.
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
        $this->createdAt = new DateTime();
    }

    /**
     * Get Name.
     *
     * @return string Transition name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Starting state.
     *
     * @return State Starting state
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get Final state.
     *
     * @return State Final state
     */
    public function getFinal()
    {
        return $this->final;
    }

    /**
     * Get CreatedAt.
     *
     * @return DateTime CreatedAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
