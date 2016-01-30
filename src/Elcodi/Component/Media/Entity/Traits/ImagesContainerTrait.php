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

namespace Elcodi\Component\Media\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait ImagesContainerTrait.
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
     * @var string
     *
     * Images sort
     */
    protected $imagesSort;

    /**
     * Set add image.
     *
     * @param \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $image Image object to be added
     *
     * @return $this Self object
     */
    public function addImage(\Elcodi\Component\Media\Entity\Interfaces\ImageInterface $image)
    {
        $this->images->add($image);

        return $this;
    }

    /**
     * Get if entity is enabled.
     *
     * @param \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $image Image object to be removed
     *
     * @return $this Self object
     */
    public function removeImage(\Elcodi\Component\Media\Entity\Interfaces\ImageInterface $image)
    {
        $this->images->removeElement($image);

        return $this;
    }

    /**
     * Get all images.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Get sorted images.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSortedImages()
    {
        $imagesSort = explode(',', $this->getImagesSort());
        $orderCollection = array_reverse($imagesSort);
        $imagesCollection = $this
            ->getImages()
            ->toArray();

        usort(
            $imagesCollection,
            function (
                \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $a,
                \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $b
            ) use ($orderCollection) {

                $aPos = array_search($a->getId(), $orderCollection);
                $bPos = array_search($b->getId(), $orderCollection);

                return ($aPos < $bPos)
                    ? 1
                    : -1;
            }
        );

        return new ArrayCollection($imagesCollection);
    }

    /**
     * Set images.
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $images Images
     *
     * @return $this Self object
     */
    public function setImages(\Doctrine\Common\Collections\ArrayCollection $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get ImagesSort.
     *
     * @return string ImagesSort
     */
    public function getImagesSort()
    {
        return $this->imagesSort;
    }

    /**
     * Sets ImagesSort.
     *
     * @param string $imagesSort ImagesSort
     *
     * @return $this Self object
     */
    public function setImagesSort($imagesSort)
    {
        $this->imagesSort = $imagesSort;

        return $this;
    }
}
