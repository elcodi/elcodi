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

namespace Elcodi\Component\Media\Entity\Interfaces;

/**
 * Class ImageInterface
 */
interface ImageInterface extends FileInterface
{
    /**
     * Set image width in pixels
     *
     * @param string $width Width
     *
     * @return $this self Object
     */
    public function setWidth($width);

    /**
     * Get image width in pixels
     *
     * @return integer
     */
    public function getWidth();

    /**
     * Set image height in pixels
     *
     * @param string $width Width
     *
     * @return $this self Object
     */
    public function setHeight($width);

    /**
     * Get image height in pixels
     *
     * @return integer
     */
    public function getHeight();
}
