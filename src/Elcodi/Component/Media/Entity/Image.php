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

namespace Elcodi\Component\Media\Entity;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Class Image.
 */
class Image extends File implements ImageInterface
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
     * Height
     */
    protected $height;

    /**
     * Set image width in pixels.
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

    /**
     * Get image width in pixels.
     *
     * @return int Width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set image height in pixels.
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
     * Get image height in pixels.
     *
     * @return int Height
     */
    public function getHeight()
    {
        return $this->height;
    }
}
