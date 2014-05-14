<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\MediaBundle\Entity\Traits;

/**
 * Trait ImagesContainerTrait
 */
trait ImagesContainerTrait
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * Images
     */
    protected $images;

    /**
     * @var \Elcodi\MediaBundle\Entity\Interfaces\ImageInterface
     *
     * Principal image
     */
    protected $principalImage;

    /**
     * Set add image
     *
     * @param \Elcodi\MediaBundle\Entity\Interfaces\ImageInterface $image Image object to be added
     *
     * @return Object self Object
     */
    public function addImage(\Elcodi\MediaBundle\Entity\Interfaces\ImageInterface $image)
    {
        $this->images->add($image);

        if (empty($this->principalImage)) {

            $this->setPrincipalImage($image);
        }

        return $this;
    }

    /**
     * Get if entity is enabled
     *
     * @param \Elcodi\MediaBundle\Entity\Interfaces\ImageInterface $image Image object to be removed
     *
     * @return Object self Object
     */
    public function removeImage(\Elcodi\MediaBundle\Entity\Interfaces\ImageInterface $image)
    {
        $this->images->removeElement($image);

        return $this;
    }

    /**
     * Get all images
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set images
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $images Images
     *
     * @return Object self Object
     */
    public function setImages(\Doctrine\Common\Collections\ArrayCollection $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Set the principalImage
     *
     * @param \Elcodi\MediaBundle\Entity\Interfaces\ImageInterface $principalImage Principal image
     *
     * @return Object self Object
     */
    public function setPrincipalImage(\Elcodi\MediaBundle\Entity\Interfaces\ImageInterface $principalImage = null)
    {
        $this->principalImage = $principalImage;

        return $this;
    }

    /**
     * Get the principalImage
     *
     * @return \Elcodi\MediaBundle\Entity\Interfaces\ImageInterface Principal image
     */
    public function getPrincipalImage()
    {
        return $this->principalImage;
    }
}
