<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\MediaBundle\Entity\Interfaces;

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
     * @return Object self Object
     */
    public function addImage(ImageInterface $image);

    /**
     * Get if entity is enabled
     *
     * @param ImageInterface $image Image object to be removed
     *
     * @return Object self Object
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
     * @return Object self Object
     */
    public function setImages(ArrayCollection $images);

    /**
     * Set the principalImage
     *
     * @param ImageInterface $principalImage Principal image
     *
     * @return ImagesContainerInterface self Object
     */
    public function setPrincipalImage(ImageInterface $principalImage = null);

    /**
     * Get the principalImage
     *
     * @return ImageInterface Principal image
     */
    public function getPrincipalImage();
}
