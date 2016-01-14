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

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Elcodi\Component\Media\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Exception\InvalidImageException;
use Elcodi\Component\Media\Factory\ImageFactory;

/**
 * Class ImageManager.
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
    private $imageFactory;

    /**
     * @var FileManager
     *
     * File manager
     */
    private $fileManager;

    /**
     * @var ResizeAdapterInterface
     *
     * ResizerAdapter
     */
    private $resizeAdapter;

    /**
     * Construct method.
     *
     * @param ImageFactory           $imageFactory  Image Factory
     * @param FileManager            $fileManager   File Manager
     * @param ResizeAdapterInterface $resizeAdapter Resize Adapter
     */
    public function __construct(
        ImageFactory $imageFactory,
        FileManager $fileManager,
        ResizeAdapterInterface $resizeAdapter
    ) {
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
     */
    public function createImage(File $file)
    {
        $fileMime = $file->getMimeType();

        if ('application/octet-stream' === $fileMime) {
            $imageSizeData = getimagesize($file->getPathname());
            $fileMime = $imageSizeData['mime'];
        }

        if (strpos($fileMime, 'image/') !== 0) {
            throw new InvalidImageException();
        }

        $extension = $file->getExtension();

        if (!$extension && $file instanceof UploadedFile) {
            $extension = $file->getClientOriginalExtension();
        }

        /**
         * @var ImageInterface $image
         */
        $image = $this->imageFactory->create();

        if (!isset($imageSizeData)) {
            $imageSizeData = getimagesize($file->getPathname());
        }
        $name = $file->getFilename();
        $image
            ->setWidth($imageSizeData[0])
            ->setHeight($imageSizeData[1])
            ->setContentType($fileMime)
            ->setSize($file->getSize())
            ->setExtension($extension)
            ->setName($name);

        return $image;
    }

    /**
     * Given an image, resize it.
     *
     * @param ImageInterface $image  Image
     * @param int            $height Height
     * @param int            $width  Width
     * @param int            $type   Type
     *
     * @return ImageInterface New Image instance
     */
    public function resize(
        ImageInterface $image,
        $height,
        $width,
        $type = ElcodiMediaImageResizeTypes::FORCE_MEASURES
    ) {
        $imageData = $this
            ->fileManager
            ->downloadFile($image)
            ->getContent();

        if (ElcodiMediaImageResizeTypes::NO_RESIZE === $type) {
            $image->setContent($imageData);

            return $image;
        }

        $resizedImageData = $this
            ->resizeAdapter
            ->resize($imageData, $height, $width, $type);

        /**
         * We need to physically store the new resized
         * image in order to access its metadata, such as
         * file size, image dimensions, mime type etc.
         * Ideally, we should be doing this in memory.
         */
        $resizedFile = new File(tempnam(sys_get_temp_dir(), '_generated'));
        file_put_contents($resizedFile, $resizedImageData);

        $image = $this->createImage($resizedFile);
        $image->setContent($resizedImageData);

        unlink($resizedFile);

        return $image;
    }
}
