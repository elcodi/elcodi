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

namespace Elcodi\Bundle\MediaBundle\DataFixtures\ORM\Traits;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Trait ImageManagerTrait.
 */
trait ImageManagerTrait
{
    /**
     * Steps necessary to store an image.
     *
     * @param string $imagePath Image path
     *
     * @return ImageInterface Generated and store image
     */
    protected function storeImage($imagePath)
    {
        /**
         * @var \Elcodi\Component\Media\Services\ImageManager                 $imageManager
         * @var \Gaufrette\Filesystem                                         $filesystem
         * @var \Elcodi\Component\Media\Transformer\FileIdentifierTransformer $fileIdentifierTransformer
         * @var \Doctrine\Common\Persistence\ObjectManager                    $imageObjectManager
         */
        $imageManager = $this->get('elcodi.manager.media_image');
        $imageObjectManager = $this->get('elcodi.object_manager.image');
        $filesystem = $this->get('elcodi.media_filesystem');
        $fileIdentifierTransformer = $this->get('elcodi.transformer.media_file_identifier');

        $image = $imageManager->createImage(new \Symfony\Component\HttpFoundation\File\File($imagePath));
        $imageObjectManager->persist($image);
        $imageObjectManager->flush($image);

        $filesystem->write(
            $fileIdentifierTransformer->transform($image),
            file_get_contents($imagePath),
            true
        );

        return $image;
    }
}
