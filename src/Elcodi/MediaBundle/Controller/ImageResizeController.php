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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Gaufrette\Adapter;

use Elcodi\MediaBundle\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;

/**
 * Class ImageController
 */
class ImageResizeController extends Controller
{
    /**
     * @var Adapter
     *
     * Filesystem adapter
     */
    protected $filesystemAdapter;

    /**
     * @var ResizeAdapterInterface
     *
     * ResizerAdapter
     */
    protected $resizeAdapter;

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
     * Set resize adapter
     *
     * @param ResizeAdapterInterface $resizeAdapter Resize adapter
     *
     * @return ImageController self Object
     */
    public function setResizeAdapter(ResizeAdapterInterface $resizeAdapter)
    {
        $this->resizeAdapter = $resizeAdapter;

        return $this;
    }

    /**
     * Resizes an image
     *
     * @param Request        $request Request
     * @param ImageInterface $image   Image
     * @param string         $height  Height
     * @param string         $width   Width
     * @param int            $type    Type
     *
     * @return Response
     *
     * @
     */
    public function resizeAction(Request $request, ImageInterface $image, $height, $width, $type)
    {
        $response = new Response();

        $response->setEtag(
            sha1($image->getId() . "." .
                $image->getUpdatedAt()->getTimestamp() . "." .
                $height . "." .
                $width . "." .
                $type
            ));

        $response->setLastModified($image->getUpdatedAt());
        $response->setPublic();

        // if the object has not been modified, we
        // return the response. Symfony will automatically
        // put a 304 status in the response in that case
        if ($response->isNotModified($request)) {
            return $response;
        }

        $fileName = (0 == $type) ?
            $image->getPath() :
            $this
                ->resizeAdapter
                ->resize($image, $height, $width, $type)
                ->getPathname();

        $response->setStatusCode(200);
        $response->setMaxAge(7884000);
        $response->setSharedMaxAge(7884000);
        $deposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );

        $response->headers->add(
            array(
                'Content-Type' => $image->getContentType(),
                'Content-Disposition' => $deposition
            )
        );

        return $response;
    }
}
 