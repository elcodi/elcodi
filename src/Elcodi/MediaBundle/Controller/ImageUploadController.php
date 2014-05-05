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

use Elcodi\MediaBundle\Factory\ImageFactory;
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
     * @var ImageFactory
     *
     * Image Factory
     */
    protected $imageFactory;

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
     * Set image factory
     *
     * @param ImageFactory $imageFactory Image Factory
     *
     * @return ImageUploadController self Object
     */
    public function setImageFactory(ImageFactory $imageFactory)
    {
        $this->imageFactory = $imageFactory;

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
     * Dinamic upload action
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
        $fileMime = $file->getMimeType();
        $image = $this->imageFactory->create();

        if (strpos($fileMime, 'image/') !== 0) {

            return new JsonResponse([
                'status' => 'ko',
            ]);
        }

        $imageSizeData = getimagesize($file->getPathname());
        $name = $file->getClientOriginalName();
        $image
            ->setWitdh($imageSizeData[0])
            ->setHeight($imageSizeData[1])
            ->setContentType($fileMime)
            ->setSize($file->getSize())
            ->setExtension($file->getExtension())
            ->setName($name);

        $this->manager->persist($image);
        $this->manager->flush($image);

        $this->filesystemAdapter->write(
            $this->fileTransformer->transform($image),
            file_get_contents($file->getRealPath())
        );

        return new JsonResponse([
            'status' => 'ok',
        ]);
    }
}
 