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

namespace Elcodi\Component\Media\Services;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\Component\Media\Entity\Interfaces\PrincipalImageInterface;

/**
 * Class ImageResolver.
 */
class ImageResolver
{
    /**
     * Return one image given a ImagesContainerInterface implementation.
     *
     * @param ImagesContainerInterface $imagesContainer Images container
     *
     * @return ImageInterface|false First image of false if any found
     */
    public function resolveImage(ImagesContainerInterface $imagesContainer)
    {
        if (
            $imagesContainer instanceof PrincipalImageInterface &&
            $imagesContainer->getPrincipalImage() instanceof ImageInterface
        ) {
            return $imagesContainer->getPrincipalImage();
        }

        $firstImage = $imagesContainer
            ->getSortedImages()
            ->first();

        return ($firstImage instanceof ImageInterface)
            ? $firstImage
            : false;
    }
}
