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

namespace Elcodi\MediaBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;
use Elcodi\MediaBundle\Repository\ImageRepository;
use Elcodi\MediaBundle\Services\ImageManager;
use Elcodi\MediaBundle\Transformer\Interfaces\ImageEtagTransformerInterface;

/**
 * Class ImageController
 */
class ImageResizeController extends Controller
{
    /**
     * @var ImageRepository
     *
     * Image repository
     */
    protected $imageRepository;

    /**
     * @var ImageManager
     *
     * Image Manager
     */
    protected $imageManager;

    /**
     * @var ImageEtagTransformerInterface
     *
     * Image ETag Transformer
     */
    protected $imageEtagTransformer;

    /**
     * @var integer
     *
     * Max size
     */
    protected $maxAge;

    /**
     * @var integer
     *
     * Shared max size
     */
    protected $sharedMaxAge;

    /**
     * Construct method
     *
     * @param ImageRepository               $imageRepository      Image Repository
     * @param ImageManager                  $imageManager         Image Manager
     * @param ImageEtagTransformerInterface $imageEtagTransformer ImageEtagTransformer Image Etag Transformer
     * @param integer                       $maxAge               Max size
     * @param integer                       $sharedMaxAge         Shared max size
     */
    public function __construct(
        ImageRepository $imageRepository,
        ImageManager $imageManager,
        ImageEtagTransformerInterface $imageEtagTransformer,
        $maxAge,
        $sharedMaxAge
    )
    {
        $this->imageRepository = $imageRepository;
        $this->imageManager = $imageManager;
        $this->imageEtagTransformer = $imageEtagTransformer;
        $this->maxAge = $maxAge;
        $this->sharedMaxAge = $sharedMaxAge;
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
    public function resizeAction(
        Request $request,
        $id,
        $height,
        $width,
        $type
    )
    {
        /**
         * We retrieve image given its id
         */
        $image = $this
            ->imageRepository
            ->find($id);

        if (!($image instanceof ImageInterface)) {

            throw new EntityNotFoundException($this->imageRepository->getClassName());
        }

        $response = new Response();

        $response
            ->setEtag($this
                    ->imageEtagTransformer
                    ->transform(
                        $image,
                        $height,
                        $width,
                        $type
                    )
            )
            ->setLastModified($image->getUpdatedAt())
            ->setStatusCode(304)
            ->setPublic();

        /**
         * If the object has not been modified, we return the response.
         * Symfony will automatically put a 304 status in the response
         * in that case
         */
        if ($response->isNotModified($request)) {
            return $response;
        }

        $image = $this
            ->imageManager
            ->resize(
                $image,
                $height,
                $width,
                $type
            );

        $imageData = $image->getContent();

        $response
            ->setStatusCode(200)
            ->setMaxAge($this->maxAge)
            ->setSharedMaxAge($this->sharedMaxAge)
            ->setContent($imageData);

        $response->headers->add(
            array(
                'Content-Type' => $image->getContentType(),
            )
        );

        return $response;
    }
}
