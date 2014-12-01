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

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures;

use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateableInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLine;

/**
 * Class Order
 */
class Order implements StateableInterface
{
    /**
     * @var array
     *
     * State Lines
     */
    public $stateLines = array();

    /**
     * Add state line
     *
     * @param StateLine $stateLine State line
     *
     * @return $this self Object
     */
    public function addStateLine(StateLine $stateLine)
    {
        $this->stateLines[] = $stateLine;
    }

    /**
     * Get last state line
     *
     * @return StateLineInterface|null last StateLine
     */
    public function getLastStateLine()
    {
        $lastStateLine = end($this->stateLines);

        return $lastStateLine;
    }
}
