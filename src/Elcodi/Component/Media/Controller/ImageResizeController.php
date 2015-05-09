<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
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
     * @return Response Response generated
     *
     * @throws RuntimeException        Request not found
     * @throws EntityNotFoundException Requested image does not exist
     */
    public function resizeAction()
    {
        $request = $this
            ->requestStack
            ->getCurrentRequest();

        /**
         * Request not found because this controller is not running under
         * Request scope
         */
        if (!($request instanceof Request)) {
            throw new RuntimeException('Request object not found');
        }

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

        return $this->buildResponseFromImage(
            $request,
            $image
        );
    }

    /**
     * Create new response given a request and an image.
     *
     * Fill some data to this response given some Image properties and check if
     * created Response has changed.
     *
     * @param Request        $request Request
     * @param ImageInterface $image   Image
     *
     * @return Response Created response
     */
    protected function buildResponseFromImage(
        Request $request,
        ImageInterface $image
    ) {
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
            ->setPublic();

        /**
         * If the object has not been modified, we return the response.
         * Symfony will automatically put a 304 status in the response
         * in that case
         */
        if ($response->isNotModified($request)) {
            return $response->setStatusCode(304);
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

        $response
            ->headers
            ->add([
                'Content-Type' => $image->getContentType(),
            ]);

        return $response;
    }
}
