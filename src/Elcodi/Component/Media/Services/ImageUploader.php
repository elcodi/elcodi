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

namespace Elcodi\Component\Media\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Exception\InvalidImageException;

/**
 * Class ImageUploader
 */
class ImageUploader
{
    /**
     * @var ObjectManager
     *
     * Image Object manager
     */
    protected $imageObjectManager;

    /**
     * @var ImageManager
     *
     * Image Manager
     */
    protected $imageManager;

    /**
     * @var FileManager
     *
     * File Manager
     */
    protected $fileManager;

    /**
     * Construct method
     *
     * @param ObjectManager $imageObjectManager Image Object Manager
     * @param FileManager   $fileManager        File Manager
     * @param ImageManager  $imageManager       Image Manager
     */
    public function __construct(
        ObjectManager $imageObjectManager,
        FileManager $fileManager,
        ImageManager $imageManager
    ) {
        $this->imageObjectManager = $imageObjectManager;
        $this->fileManager = $fileManager;
        $this->imageManager = $imageManager;
    }

    /**
     * Upload an image
     *
     * @param UploadedFile $file File to upload
     *
     * @return ImageInterface|null Uploaded image or false is error
     *
     * @throws InvalidImageException File is not an image
     */
    public function uploadImage(UploadedFile $file)
    {
        $image = $this
            ->imageManager
            ->createImage($file);

        $this->imageObjectManager->persist($image);
        $this->imageObjectManager->flush($image);

        $this->fileManager->uploadFile(
            $image,
            file_get_contents($file->getRealPath()),
            true
        );

        return $image;
    }
}
