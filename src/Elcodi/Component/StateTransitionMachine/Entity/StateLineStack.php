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

namespace Elcodi\Component\StateTransitionMachine\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;

/**
 * Class StateLineStack.
 */
class StateLineStack
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
     * Construct.
     *
     * @param Collection         $stateLines    State Lines
     * @param StateLineInterface $lastStateLine Last stateLine
     */
    public function __construct(
        Collection $stateLines,
        StateLineInterface $lastStateLine = null
    ) {
        $this->stateLines = $stateLines;
        $this->lastStateLine = $lastStateLine;
    }

    /**
     * Add state line.
     *
     * @param StateLineInterface $stateLine State line
     *
     * @return $this Self object
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
     * Remove state line.
     *
     * @param StateLineInterface $stateLine State line
     *
     * @return $this Self object
     */
    public function removeStateLine(StateLineInterface $stateLine)
    {
        $this
            ->stateLines
            ->removeElement($stateLine);

        return $this;
    }

    /**
     * Get state lines.
     *
     * @return Collection StateLines
     */
    public function getStateLines()
    {
        return $this->stateLines;
    }

    /**
     * Get LastStateLine.
     *
     * @return StateLineInterface LastStateLine
     */
    public function getLastStateLine()
    {
        return $this->lastStateLine;
    }

    /**
     * Create new StateLineStack.
     *
     * @param Collection         $stateLines    State Lines
     * @param StateLineInterface $lastStateLine Last stateLine
     *
     * @return self New instance
     */
    public static function create(
        Collection $stateLines,
        StateLineInterface $lastStateLine = null
    ) {
        return new self($stateLines, $lastStateLine);
    }
}
