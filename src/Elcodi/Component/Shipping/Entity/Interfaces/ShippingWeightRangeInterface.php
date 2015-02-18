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

namespace Elcodi\Component\Shipping\Entity\Interfaces;

/**
 * Interface ShippingWeightRangeInterface
 */
interface ShippingWeightRangeInterface
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
     * @return $this Self object
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
     * @return $this Self object
     */
    public function setFromWeight($fromWeight);
}
