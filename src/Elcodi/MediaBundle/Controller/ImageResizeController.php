<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Elcodi\MediaBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Gaufrette\Adapter;

use Elcodi\MediaBundle\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;
use Elcodi\MediaBundle\Transformer\FileTransformer;

/**
 * Class ImageController
 */
class ImageResizeController extends Controller
{
    /**
     * @var ObjectManager
     *
     * Entity manager
     */
    protected $manager;

    /**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;

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
     * @var ResizeAdapterInterface
     *
     * ResizerAdapter
     */
    protected $resizeAdapter;

    /**
     * Set entityManager
     *
     * @param ObjectManager $manager Entity manager
     *
     * @return ImageResizeController self Object
     */
    public function setEntityManager(ObjectManager $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Set entityManager
     *
     * @param string $imageNamespace Image namespace
     *
     * @return ImageResizeController self Object
     */
    public function setImageNamespace($imageNamespace)
    {
        $this->imageNamespace = $imageNamespace;

        return $this;
    }

    /**
     * Set filesystem adapter
     *
     * @param Adapter $filesystemAdapter Adapter
     *
     * @return ImageResizeController self Object
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
     * @return ImageResizeController self Object
     */
    public function setFileTransformer(FileTransformer $fileTransformer)
    {
        $this->fileTransformer = $fileTransformer;

        return $this;
    }

    /**
     * Set resize adapter
     *
     * @param ResizeAdapterInterface $resizeAdapter Resize adapter
     *
     * @return ImageResizeController self Object
     */
    public function setResizeAdapter(ResizeAdapterInterface $resizeAdapter)
    {
        $this->resizeAdapter = $resizeAdapter;

        return $this;
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
     * @throws \RuntimeException
     */
    public function resizeAction(Request $request, $id, $height, $width, $type)
    {
        /**
         * We retrieve image given its id
         */


        $imageRepository = $this->manager->getRepository($this->imageNamespace);
        $image = $imageRepository->find($id);

        if (!($image instanceof ImageInterface)) {

            throw $this->createNotFoundException('The image does not exist');
        }

        $response = new Response();

        $response->setEtag(
            sha1($id . "." .
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

        $imagePath = $this->fileTransformer->transform($image);
        $imageData = $this->filesystemAdapter->read($imagePath);

        if (0 !== $type) {

            $imageData = $this
                ->resizeAdapter
                ->resize($imageData, $height, $width, $type);
        }

        $response->setStatusCode(200);
        $response->setMaxAge(7884000);
        $response->setSharedMaxAge(7884000);
        $response->setContent($imageData);

        $response->headers->add(
            array(
                'Content-Type' => $image->getContentType(),
            )
        );

        return $response;
    }
}
 