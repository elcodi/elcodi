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

namespace Elcodi\Component\Product\Entity\Interfaces;

/**
 * Interface DimensionableInterface.
 */
interface DimensionableInterface
{
    /**
     * Get Depth.
     *
     * @return int Depth
     */
    public function getDepth();

    /**
     * Get Height.
     *
     * @return int Height
     */
    public function getHeight();

    /**
     * Get Weight.
     *
     * @return int Weight
     */
    public function getWeight();

    /**
     * Get Width.
     *
     * @return int Width
     */
    public function getWidth();
}
