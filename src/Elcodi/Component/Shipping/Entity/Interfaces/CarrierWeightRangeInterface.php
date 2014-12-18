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

namespace Elcodi\Component\Shipping\Entity\Interfaces;

/**
 * Interface CarrierWeightRangeInterface
 */
interface CarrierWeightRangeInterface extends CarrierBaseRangeInterface
{
    /**
     * Get ToWeight
     *
     * @return int ToWeight
     */
    public function getToWeight();

    /**
     * Sets ToWeight
     *
     * @param int $toWeight ToWeight
     *
     * @return self
     */
    public function setToWeight($toWeight);

    /**
     * Get FromWeight
     *
     * @return int FromWeight
     */
    public function getFromWeight();

    /**
     * Sets FromWeight
     *
     * @param int $fromWeight FromWeight
     *
     * @return self
     */
    public function setFromWeight($fromWeight);
}
