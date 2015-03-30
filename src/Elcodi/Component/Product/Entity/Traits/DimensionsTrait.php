<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
 * Trait DimensionsTrait
 */
trait DimensionsTrait
{
    /**
     * @var integer
     *
     * Width
     */
    protected $width;

    /**
     * @var integer
     *
     * height
     */
    protected $height;

    /**
     * @var integer
     *
     * depth
     */
    protected $depth;

    /**
     * @var integer
     *
     * weight
     */
    protected $weight;

    /**
     * Get Depth
     *
     * @return integer Depth
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Sets Depth
     *
     * @param integer $depth Depth
     *
     * @return $this Self object
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get Height
     *
     * @return integer Height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets Height
     *
     * @param integer $height Height
     *
     * @return $this Self object
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get Weight
     *
     * @return integer Weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Sets Weight
     *
     * @param integer $weight Weight
     *
     * @return $this Self object
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get Width
     *
     * @return integer Width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets Width
     *
     * @param integer $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }
}
