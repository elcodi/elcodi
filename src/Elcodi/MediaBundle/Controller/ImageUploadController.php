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

namespace Elcodi\MediaBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Gaufrette\Adapter;

use Elcodi\MediaBundle\Exception\InvalidImageException;
use Elcodi\MediaBundle\Services\ImageManager;
use Elcodi\MediaBundle\Transformer\FileTransformer;

/**
 * Class ImageUploadController
 */
class ImageUploadController extends Controller
{
    /**
     * @var ObjectManager
     *
     * Entity manager
     */
    protected $manager;

    /**
     * @var ImageManager
     *
     * Image Manager
     */
    protected $imageManager;

    /**
     * @var Adapter
     *
     * Filesystem adapter
     */
    protected $filesystemAdapter;

    /**
     * @var FileTransformer
     *
     * File Transformer
     */
    protected $fileTransformer;

    /**
     * @var string
     *
     * Field name when uploading
     */
    protected $fieldName;

    /**
     * Set entityManager
     *
     * @param ObjectManager $manager Entity manager
     *
     * @return ImageUploadController self Object
     */
    public function setEntityManager(ObjectManager $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Set image manager
     *
     * @param ImageManager $imageManager Image Manager
     *
     * @return ImageUploadController self Object
     */
    public function setImageManager(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;

        return $this;
    }

    /**
     * Set filesystem adapter
     *
     * @param Adapter $filesystemAdapter Adapter
     *
     * @return ImageUploadController self Object
     */
    public function setFilesystemAdapter(Adapter $filesystemAdapter)
    {
        $this->filesystemAdapter = $filesystemAdapter;

        return $this;
    }

    /**
     * Set file transformer
     *
     * @param FileTransformer $fileTransformer File transformer
     *
     * @return ImageUploadController self Object
     */
    public function setFileTransformer(FileTransformer $fileTransformer)
    {
        $this->fileTransformer = $fileTransformer;

        return $this;
    }

    /**
     * Set field name
     *
     * @param string $fieldName Field name
     *
     * @return ImageUploadController Self object
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * Dynamic upload action
     *
     * @param Request $request Current request
     *
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        /**
         * @var $file UploadedFile
         */
        $file = $request->files->get($this->fieldName);

        try {


        } catch (InvalidImageException $exception) {

            return new JsonResponse([
                'status' => 'ko',
            ]);
        }

        $image = $this->imageManager->createImage($file);

        $this->filesystemAdapter->write(
            $this->fileTransformer->transform($image),
            file_get_contents($file->getRealPath())
        );

        $this->manager->persist($image);
        $this->manager->flush();

        return new JsonResponse([
            'status' => 'ok',
        ]);
    }
}
