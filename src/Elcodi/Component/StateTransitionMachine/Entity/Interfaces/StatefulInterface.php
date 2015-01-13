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

namespace Elcodi\Component\StateTransitionMachine\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Interface StatefulInterface
 */
interface StatefulInterface
{
    /**
     * Set state lines
     *
     * @param Collection $stateLines State lines
     *
     * @return $this Self object
     */
    public function setStateLines(Collection $stateLines);

    /**
     * Get state lines
     *
     * @return Collection StateLines
     */
    public function getStateLines();

    /**
     * Add state line
     *
     * @param StateLineInterface $stateLine State line
     *
     * @return $this Self object
     */
    public function addStateLine(StateLineInterface $stateLine);

    /**
     * Remove state line
     *
     * @param StateLineInterface $stateLine State line
     *
     * @return $this Self object
     */
    public function removeStateLine(StateLineInterface $stateLine);

    /**
     * Get LastStateLine
     *
     * @return StateLineInterface LastStateLine
     */
    public function getLastStateLine();
}
