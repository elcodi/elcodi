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

namespace Elcodi\Component\Media\Entity\Traits;

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
     * Set add image
     *
     * @param \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $image Image object to be added
     *
     * @return $this self Object
     */
    public function addImage(\Elcodi\Component\Media\Entity\Interfaces\ImageInterface $image)
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
     * @param \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $image Image object to be removed
     *
     * @return $this self Object
     */
    public function removeImage(\Elcodi\Component\Media\Entity\Interfaces\ImageInterface $image)
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
     * @return $this self Object
     */
    public function setImages(\Doctrine\Common\Collections\ArrayCollection $images)
    {
        $this->images = $images;

        return $this;
    }
}
