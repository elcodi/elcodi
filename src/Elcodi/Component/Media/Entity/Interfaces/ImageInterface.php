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

namespace Elcodi\Component\Media\Entity\Interfaces;

/**
 * Interface ImageInterface.
 */
interface ImageInterface extends FileInterface
{
    /**
     * Set image width in pixels.
     *
     * @param int $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width);

    /**
     * Get image width in pixels.
     *
     * @return int
     */
    public function getWidth();

    /**
     * Set image height in pixels.
     *
     * @param int $width Width
     *
     * @return $this Self object
     */
    public function setHeight($width);

    /**
     * Get image height in pixels.
     *
     * @return int
     */
    public function getHeight();
}
