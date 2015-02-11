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

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;

/**
 * Class Order
 */
class Order
{
    /**
     * @var StateLineInterface
     *
     * Last stateLine in  stateLine stack
     */
    protected $LastStateLine;

    /**
     * @var Collection
     *
     * StateLines for
     */
    protected $StateLines;

    /**
     * Get StateLineStack
     *
     * @return StateLineStack StateLineStack
     */
    public function getStateLineStack()
    {
        return StateLineStack::create(
            $this->StateLines,
            $this->LastStateLine
        );
    }

    /**
     * Sets StateLineStack
     *
     * @param StateLineStack $StateLineStack StateLineStack
     *
     * @return $this Self object
     */
    public function setStateLineStack(StateLineStack $StateLineStack)
    {
        $this->StateLines = $StateLineStack->getStateLines();
        $this->LastStateLine = $StateLineStack->getLastStateLine();

        return $this;
    }
}
