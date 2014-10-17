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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ImagesContainerInterface
 */
interface ImagesContainerInterface
{
    /**
     * Set add image
     *
     * @param ImageInterface $image Image object to be added
     *
     * @return $this self Object
     */
    public function addImage(ImageInterface $image);

    /**
     * Get if entity is enabled
     *
     * @param ImageInterface $image Image object to be removed
     *
     * @return $this self Object
     */
    public function removeImage(ImageInterface $image);

    /**
     * Get all images
     *
     * @return ArrayCollection
     */
    public function getImages();

    /**
     * Set images
     *
     * @param ArrayCollection $images Images
     *
     * @return $this self Object
     */
    public function setImages(ArrayCollection $images);
}
