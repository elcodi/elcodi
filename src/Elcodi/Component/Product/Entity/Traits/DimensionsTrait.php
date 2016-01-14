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

namespace Elcodi\Component\Product\Entity\Traits;

/**
 * Trait DimensionsTrait.
 */
trait DimensionsTrait
{
    /**
     * @var int
     *
     * Width
     */
    protected $width;

    /**
     * @var int
     *
     * height
     */
    protected $height;

    /**
     * @var int
     *
     * depth
     */
    protected $depth;

    /**
     * @var int
     *
     * weight
     */
    protected $weight;

    /**
     * Get Depth.
     *
     * @return int Depth
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Sets Depth.
     *
     * @param int $depth Depth
     *
     * @return $this Self object
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get Height.
     *
     * @return int Height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets Height.
     *
     * @param int $height Height
     *
     * @return $this Self object
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get Weight.
     *
     * @return int Weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Sets Weight.
     *
     * @param int $weight Weight
     *
     * @return $this Self object
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get Width.
     *
     * @return int Width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets Width.
     *
     * @param int $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }
}
