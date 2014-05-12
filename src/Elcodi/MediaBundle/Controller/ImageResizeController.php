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

namespace Elcodi\MediaBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;
use Elcodi\MediaBundle\Services\FileManager;
use Elcodi\MediaBundle\Services\ImageManager;

/**
 * Class ImageController
 */
class ImageResizeController extends Controller
{
    /**
     * @var ObjectManager
     *
     * Object manager
     */
    protected $objectManager;

    /**
     * @var FileManager
     *
     * File manager
     */
    protected $fileManager;

    /**
     * @var ImageManager
     *
     * Image Manager
     */
    protected $imageManager;

    /**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;

    /**
     * @var integer
     *
     * Max size
     */
    protected $maxSize;

    /**
     * @var integer
     *
     * Shared max size
     */
    protected $sharedMaxSize;

    /**
     * Construct method
     *
     * @param ObjectManager $objectManager  Object Manager
     * @param FileManager   $fileManager    File Manager
     * @param ImageManager  $imageManager   Image Manager
     * @param string        $imageNamespace Image namespace
     * @param integer       $maxSize        Max size
     * @param integer       $sharedMaxSize  Shared max size
     */
    public function __construct(
        ObjectManager $objectManager,
        FileManager $fileManager,
        ImageManager $imageManager,
        $imageNamespace,
        $maxSize,
        $sharedMaxSize
    )
    {
        $this->objectManager = $objectManager;
        $this->fileManager = $fileManager;
        $this->imageManager = $imageManager;
        $this->imageNamespace = $imageNamespace;
        $this->maxSize = $maxSize;
        $this->sharedMaxSize = $sharedMaxSize;
    }

    /**
     * Resizes an image
     *
     * @param Request $request Request
     * @param integer $id      Image id
     * @param string  $height  Height
     * @param string  $width   Width
     * @param int     $type    Type
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function resizeAction(Request $request, $id, $height, $width, $type)
    {
        /**
         * We retrieve image given its id
         */
        $imageRepository = $this->objectManager->getRepository($this->imageNamespace);
        $image = $imageRepository->find($id);

        if (!($image instanceof ImageInterface)) {

            throw new EntityNotFoundException($this->imageNamespace);
        }

        $response = new Response();

        $response->setEtag(
            sha1(
                $id . "." .
                $image->getUpdatedAt()->getTimestamp() . "." .
                $height . "." .
                $width . "." .
                $type
            )
        );

        $response->setLastModified($image->getUpdatedAt());
        $response->setPublic();

        /**
         * If the object has not been modified, we return the response.
         * Symfony will automatically put a 304 status in the response
         * in that case
         */
        if ($response->isNotModified($request)) {

            return $response;
        }

        $image = $this->imageManager->resize($image, $height, $width, $type);
        $imageData = $image->getContent();

        $response->setStatusCode(200);
        $response->setMaxAge($this->maxSize);
        $response->setSharedMaxAge($this->sharedMaxSize);
        $response->setContent($imageData);

        $response->headers->add(
            array(
                'Content-Type' => $image->getContentType(),
            )
        );

        return $response;
    }
}
