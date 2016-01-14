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

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM\Traits;

use Elcodi\Bundle\MediaBundle\DataFixtures\ORM\Traits\ImageManagerTrait;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface;

/**
 * Trait ProductWithImagesTrait.
 */
trait ProductWithImagesTrait
{
    use ImageManagerTrait;

    /**
     * Steps necessary to store an image.
     *
     * @param ImagesContainerWithPrincipalImageInterface $imageContainer Image Container
     * @param string                                     $imageName      Image name
     *
     * @return $this Self object
     */
    protected function storeProductImage(
        ImagesContainerWithPrincipalImageInterface $imageContainer,
        $imageName
    ) {
        $imagePath = realpath(__DIR__ . '/../images/' . $imageName);
        $image = $this->storeImage($imagePath);

        $imageContainer->addImage($image);
        $imageContainer->setPrincipalImage($image);

        return $this;
    }
}
