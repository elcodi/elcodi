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

namespace Elcodi\Component\Core\Entity\Interfaces;

use DateTime;

/**
 * Interface ValidIntervalInterface.
 */
interface ValidIntervalInterface
{
    /**
     * Set valid from.
     *
     * @param DateTime $validFrom Valid from
     *
     * @return $this Self object
     */
    public function setValidFrom(DateTime $validFrom);

    /**
     * Get valid from.
     *
     * @return DateTime
     */
    public function getValidFrom();

    /**
     * Set valid to.
     *
     * @param DateTime $validTo Valid to
     *
     * @return $this Self object
     */
    public function setValidTo(DateTime $validTo = null);

    /**
     * Get valid to.
     *
     * @return DateTime Valid to
     */
    public function getValidTo();
}
