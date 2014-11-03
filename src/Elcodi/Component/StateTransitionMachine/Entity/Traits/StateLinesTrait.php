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

namespace Elcodi\Component\StateTransitionMachine\Entity\Traits;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;

/**
 * Trait StateLinesTrait
 */
trait StateLinesTrait
{
    /**
     * @var Collection
     *
     * State lines
     */
    protected $stateLines;

    /**
     * @var StateLineInterface
     *
     * Last OrderLineHistory
     */
    protected $lastStateLine;

    /**
     * Add state line
     *
     * @param StateLineInterface $stateLine State line
     *
     * @return $this self Object
     */
    public function addStateLine(StateLineInterface $stateLine)
    {
        $this
            ->stateLines
            ->add($stateLine);

        $this->lastStateLine = $stateLine;

        return $this;
    }

    /**
     * Remove state line
     *
     * @param StateLineInterface $stateLine State line
     *
     * @return $this self Object
     */
    public function removeStateLine(StateLineInterface $stateLine)
    {
        $this
            ->stateLines
            ->removeElement($stateLine);

        return $this;
    }

    /**
     * Set state lines
     *
     * @param Collection $stateLines State lines
     *
     * @return $this self Object
     */
    public function setStateLines(Collection $stateLines)
    {
        $this->stateLines = $stateLines;

        return $this;
    }

    /**
     * Get state lines
     *
     * @return Collection StateLines
     */
    public function getStateLines()
    {
        return $this->stateLines;
    }

    /**
     * Get LastStateLine
     *
     * @return StateLineInterface LastStateLine
     */
    public function getLastStateLine()
    {
        return $this->lastStateLine;
    }
}
