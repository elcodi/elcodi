<?php

/**
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

namespace Elcodi\Component\Media\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Media\Exception\InvalidImageException;
use Elcodi\Component\Media\Services\FileManager;
use Elcodi\Component\Media\Services\ImageManager;

/**
 * Class ImageUploadController
 */
class ImageUploadController
{
    /**
     * @var RequestStack
     *
     * Request stack
     */
    protected $requestStack;

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
     * @var string
     *
     * Field name when uploading
     */
    protected $uploadFieldName;

    /**
     * Construct method
     *
     * @param RequestStack  $requestStack       Request Stack
     * @param ObjectManager $imageObjectManager Image Object Manager
     * @param FileManager   $fileManager        File Manager
     * @param ImageManager  $imageManager       Image Manager
     * @param string        $uploadFieldName    Field name when uploading
     */
    public function __construct(
        RequestStack $requestStack,
        ObjectManager $imageObjectManager,
        FileManager $fileManager,
        ImageManager $imageManager,
        $uploadFieldName
    )
    {
        $this->requestStack = $requestStack;
        $this->imageObjectManager = $imageObjectManager;
        $this->fileManager = $fileManager;
        $this->imageManager = $imageManager;
        $this->uploadFieldName = $uploadFieldName;
    }

    /**
     * Dynamic upload action
     *
     * @return Response
     */
    public function uploadAction()
    {
        $request = $this
            ->requestStack
            ->getCurrentRequest();

        /**
         * @var $file UploadedFile
         */
        $file = $request
            ->files
            ->get($this->uploadFieldName);

        try {
            $image = $this->imageManager->createImage($file);

        } catch (InvalidImageException $exception) {
            return new JsonResponse([
                'status' => 'ko',
            ]);
        }

        $this->imageObjectManager->persist($image);
        $this->imageObjectManager->flush($image);

        $this->fileManager->uploadFile(
            $image,
            file_get_contents($file->getRealPath()),
            true
        );

        return new JsonResponse([
            'status' => 'ok',
        ]);
    }
}
