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

namespace Elcodi\MediaBundle\Services;

use Symfony\Component\HttpFoundation\File\File;

use Elcodi\MediaBundle\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\MediaBundle\ElcodiMediaImageResizeTypes;
use Elcodi\MediaBundle\Factory\ImageFactory;
use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;
use Elcodi\MediaBundle\Exception\InvalidImageException;

/**
 * Class ImageManager
 *
 * This class manages images
 *
 * Public Methods:
 *
 * * createImage(File)
 * * resize(ImageInterface, $height, $width, $type)
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
     * @var FileManager
     *
     * File manager
     */
    protected $fileManager;

    /**
     * @var ResizeAdapterInterface
     *
     * ResizerAdapter
     */
    protected $resizeAdapter;

    /**
     * Construct method
     *
     * @param ImageFactory           $imageFactory  Image Factory
     * @param FileManager            $fileManager   File Manager
     * @param ResizeAdapterInterface $resizeAdapter Resize Adapter
     */
    public function __construct(
        ImageFactory $imageFactory,
        FileManager $fileManager,
        ResizeAdapterInterface $resizeAdapter
    )
    {
        $this->imageFactory = $imageFactory;
        $this->fileManager = $fileManager;
        $this->resizeAdapter = $resizeAdapter;
    }

    /**
     * Given a single File, assuming is an image, create a new
     * Image object containing all needed information.
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
            ->setPath($file->getPath())
            ->setName($name);

        return $image;
    }

    /**
     * Given an image, resize it.
     *
     * @param ImageInterface $image  Image
     * @param integer        $height Height
     * @param integer        $width  Width
     * @param integer        $type   Type
     *
     * @return ImageInterface New Image instance
     *
     * @api
     */
    public function resize(
        ImageInterface $image,
        $height,
        $width,
        $type = ElcodiMediaImageResizeTypes::FORCE_MEASURES
    )
    {
        if (ElcodiMediaImageResizeTypes::NO_RESIZE === $type) {
            return $image;
        }

        $imageData = $this
            ->fileManager
            ->downloadFile($image)
            ->getContent();

        $resizedImageData = $this
            ->resizeAdapter
            ->resize($imageData, $height, $width, $type);

        $resizedFile = new File(tempnam(sys_get_temp_dir(), '_generated'));
        file_put_contents($resizedFile, $resizedImageData);

        $image = $this->createImage($resizedFile);
        $image->setContent($resizedImageData);

        return $image;
    }
}
