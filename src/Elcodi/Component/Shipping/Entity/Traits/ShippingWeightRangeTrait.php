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

namespace Elcodi\Component\Shipping\Entity\Traits;

/**
 * Trait ShippingWeightRangeTrait
 */
trait ShippingWeightRangeTrait
{
    /**
     * @var integer
     *
     * fromWeight
     */
    protected $fromWeight;

    /**
     * @var integer
     *
     * toWeight
     */
    protected $toWeight;

    /**
     * Get ToWeight
     *
     * @return int ToWeight
     */
    public function getToWeight()
    {
        return $this->toWeight;
    }

    /**
     * Sets ToWeight
     *
     * @param int $toWeight ToWeight
     *
     * @return $this Self object
     */
    public function setToWeight($toWeight)
    {
        $this->toWeight = $toWeight;

        return $this;
    }

    /**
     * Get FromWeight
     *
     * @return int FromWeight
     */
    public function getFromWeight()
    {
        return $this->fromWeight;
    }

    /**
     * Sets FromWeight
     *
     * @param int $fromWeight FromWeight
     *
     * @return $this Self object
     */
    public function setFromWeight($fromWeight)
    {
        $this->fromWeight = $fromWeight;

        return $this;
    }
}
