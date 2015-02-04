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
 */

namespace Elcodi\Component\Media\Controller;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

use Elcodi\Component\Media\Services\ImageUploader;

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
     * @var ImageUploader
     *
     * Image uploader
     */
    protected $imageUploader;

    /**
     * @var RouterInterface
     *
     * Router
     */
    protected $router;

    /**
     * @var string
     *
     * Field name when uploading
     */
    protected $uploadFieldName;

    /**
     * @var string
     *
     * View image url name
     */
    protected $viewImageUrlName;

    /**
     * @var string
     *
     * Resize image url name
     */
    protected $resizeImageUrlName;

    /**
     * Image uploader
     *
     * @param RequestStack    $requestStack       Request stack
     * @param ImageUploader   $imageUploader      Image uploader
     * @param RouterInterface $router             Router
     * @param string          $uploadFieldName    Field name when uploading
     * @param string          $viewImageUrlName   View image url name
     * @param string          $resizeImageUrlName Resize image url name
     */
    public function __construct(
        RequestStack $requestStack,
        ImageUploader $imageUploader,
        RouterInterface $router,
        $uploadFieldName,
        $viewImageUrlName,
        $resizeImageUrlName
    ) {
        $this->requestStack = $requestStack;
        $this->imageUploader = $imageUploader;
        $this->router = $router;
        $this->uploadFieldName = $uploadFieldName;
        $this->viewImageUrlName = $viewImageUrlName;
        $this->resizeImageUrlName = $resizeImageUrlName;
    }

    /**
     * Dynamic upload action
     *
     * @return JsonResponse Upload response
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

        if (!($file instanceof UploadedFile)) {
            return new JsonResponse([
                'status'   => 'ko',
                'response' => [
                    'message' => 'Image not found',
                ],
            ]);
        }

        try {
            $image = $this
                ->imageUploader
                ->uploadImage($file);

            $routes = $this
                ->router
                ->getRouteCollection();

            $response = [
                'status'   => 'ok',
                'response' => [
                    'id'        => $image->getId(),
                    'extension' => $image->getExtension(),
                    'routes'    => [
                        'view'   => $routes
                            ->get($this->viewImageUrlName)
                            ->getPath(),
                        'resize' => $routes
                            ->get($this->resizeImageUrlName)
                            ->getPath(),
                    ],
                ],
            ];
        } catch (Exception $exception) {
            $response = [
                'status'   => 'ko',
                'response' => [
                    'message' => $exception->getMessage(),
                ],
            ];
        }

        return new JsonResponse($response);
    }
}
