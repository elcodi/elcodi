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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Media\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Repository\ImageRepository;
use Elcodi\Component\Media\Services\ImageManager;
use Elcodi\Component\Media\Transformer\Interfaces\ImageEtagTransformerInterface;

/**
 * Class ImageController
 */
class ImageResizeController
{
    /**
     * @var RequestStack
     *
     * Request stack
     */
    protected $requestStack;

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
     * @param RequestStack                  $requestStack         Request Stack
     * @param ImageRepository               $imageRepository      Image Repository
     * @param ImageManager                  $imageManager         Image Manager
     * @param ImageEtagTransformerInterface $imageEtagTransformer ImageEtagTransformer Image Etag Transformer
     * @param integer                       $maxAge               Max size
     * @param integer                       $sharedMaxAge         Shared max size
     */
    public function __construct(
        RequestStack $requestStack,
        ImageRepository $imageRepository,
        ImageManager $imageManager,
        ImageEtagTransformerInterface $imageEtagTransformer,
        $maxAge,
        $sharedMaxAge
    ) {
        $this->requestStack = $requestStack;
        $this->imageRepository = $imageRepository;
        $this->imageManager = $imageManager;
        $this->imageEtagTransformer = $imageEtagTransformer;
        $this->maxAge = $maxAge;
        $this->sharedMaxAge = $sharedMaxAge;
    }

    /**
     * Resizes an image
     *
     * @return Response
     *
     * @throws EntityNotFoundException Requested image does not exist
     */
    public function resizeAction()
    {
        $request = $this
            ->requestStack
            ->getCurrentRequest();

        $id = $request->get('id');

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
        $height = $request->get('height');
        $width = $request->get('width');
        $type = $request->get('type');
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
