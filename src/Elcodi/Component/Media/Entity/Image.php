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

namespace Elcodi\Component\Media\Entity;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Class Image
 */
class Image extends File implements ImageInterface
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
     * Height
     */
    protected $height;

    /**
     * Set image width in pixels
     *
     * @param string $width Width
     *
     * @return $this self Object
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get image width in pixels
     *
     * @return integer Width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set image height in pixels
     *
     * @param string $height Height
     *
     * @return $this self Object
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get image height in pixels
     *
     * @return integer Height
     */
    public function getHeight()
    {
        return $this->height;
    }
}
