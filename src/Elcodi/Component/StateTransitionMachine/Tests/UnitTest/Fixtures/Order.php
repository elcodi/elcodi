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

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;

/**
 * Class Order.
 */
class Order
{
    /**
     * @var StateLineInterface
     *
     * Last stateLine in stateLine stack
     */
    protected $lastStateLine;

    /**
     * @var Collection
     *
     * StateLines for
     */
    protected $stateLines;

    /**
     * Get StateLineStack.
     *
     * @return StateLineStack StateLineStack
     */
    public function getStateLineStack()
    {
        return StateLineStack::create(
            $this->stateLines,
            $this->lastStateLine
        );
    }

    /**
     * Sets StateLineStack.
     *
     * @param StateLineStack $stateLineStack StateLineStack
     *
     * @return $this Self object
     */
    public function setStateLineStack(StateLineStack $stateLineStack)
    {
        $this->stateLines = $stateLineStack->getStateLines();
        $this->lastStateLine = $stateLineStack->getLastStateLine();

        return $this;
    }
}
