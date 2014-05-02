<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version  */
 
namespace Elcodi\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Mmoreram\ControllerExtraBundle\Annotation\Entity;
use Mmoreram\ControllerExtraBundle\Annotation\Flush;
use Gaufrette\Adapter;

use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;

/**
 * Class ImageUploadController
 */
class ImageUploadController extends Controller
{
    /**
     * @var Adapter
     *
     * Filesystem adapter
     */
    protected $filesystemAdapter;

    /**
     * @var string
     *
     * Field name when uploading
     */
    protected $fieldName;

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
     * @param Request        $request Current request
     * @param ImageInterface $image   Image media empty entity
     *
     * @return Response
     *
     * @Entity(
     *      class = "ElcodiMediaBundle:Image",
     *      name = "image",
     *      persist = true,
     *      factoryClass = "elcodi.core.media.factory.image",
     *      factoryMethod = "create",
     * )
     * @flush
     * @JsonResponse
     */
    public function uploadAction(Request $request, ImageInterface $image)
    {
        /**
         * @var $file UploadedFile
         */
        $file = $request->files->get($this->fieldName);
        $fileMime = $file->getMimeType();

        if (strpos($fileMime, 'image/') !== 0) {

            return [
                'status' => 'ko',
            ];
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

        $this->filesystemAdapter->write(
            $name,
            file_get_contents($file->getRealPath())
        );

        return [
            'status' => 'ok',
        ];
    }
}
 