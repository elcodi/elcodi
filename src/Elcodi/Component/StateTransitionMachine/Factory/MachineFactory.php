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

namespace Elcodi\Component\StateTransitionMachine\Factory;

use Elcodi\Component\StateTransitionMachine\Definition\TransitionChain;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;
use Elcodi\Component\StateTransitionMachine\Machine\Machine;

/**
 * Class MachineFactory.
 */
class MachineFactory
{
    /**
     * Generate new machine.
     *
     * @param int             $machineId       Machine id
     * @param TransitionChain $transitionChain Transition Chain
     * @param string          $pointOfEntry    Point of entry
     *
     * @return MachineInterface new Machine
     */
    public function generate(
        $machineId,
        TransitionChain $transitionChain,
        $pointOfEntry
    ) {
        $machine = new Machine(
            $machineId,
            $transitionChain,
            $pointOfEntry
        );

        return $machine;
    }
}
