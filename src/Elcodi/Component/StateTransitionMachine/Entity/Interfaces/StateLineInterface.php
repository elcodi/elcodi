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

/**
 * Interface StateLineInterface
 */
interface StateLineInterface
{
    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription();
}
