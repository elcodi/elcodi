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

namespace Elcodi\MediaBundle\Services;

use Symfony\Component\HttpFoundation\File\File;
use Gaufrette\Adapter;

use Elcodi\MediaBundle\Factory\ImageFactory;
use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;
use Elcodi\MediaBundle\Exception\InvalidImageException;

/**
 * Class ImageManager
 */
class ImageManager
{
    /**
     * @var ImageFactory
     *
     * imageFactory
     */
    protected $imageFactory;

    /**
     * Construct method
     *
     * @param ImageFactory $imageFactory Image Factory
     */
    public function __construct(ImageFactory $imageFactory)
    {
        $this->imageFactory = $imageFactory;
    }

    /**
     * Given a single File, assuming is an image, cretaes a new Image object
     * containing all needed information.
     *
     * This method also persists and flush created entity
     *
     * @param File $file File where to get the image
     *
     * @return ImageInterface Image created
     *
     * @throws InvalidImageException File is not an image
     *
     * @api
     */
    public function createImage(File $file)
    {
        $fileMime = $file->getMimeType();

        if (strpos($fileMime, 'image/') !== 0) {

            throw new InvalidImageException;
        }

        /**
         * @var ImageInterface $image
         */
        $image = $this->imageFactory->create();

        $imageSizeData = getimagesize($file->getPathname());
        $name = $file->getFilename();
        $image
            ->setWidth($imageSizeData[0])
            ->setHeight($imageSizeData[1])
            ->setContentType($fileMime)
            ->setSize($file->getSize())
            ->setExtension($file->getExtension())
            ->setName($name);

        return $image;
    }
}
 