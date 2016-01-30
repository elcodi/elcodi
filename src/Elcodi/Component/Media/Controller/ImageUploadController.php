<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

use Elcodi\Component\Media\Services\ImageUploader;

/**
 * Class ImageUploadController.
 */
class ImageUploadController
{
    /**
     * @var RequestStack
     *
     * Request stack
     */
    private $requestStack;

    /**
     * @var ImageUploader
     *
     * Image uploader
     */
    private $imageUploader;

    /**
     * @var RouterInterface
     *
     * Router
     */
    private $router;

    /**
     * @var string
     *
     * Field name when uploading
     */
    private $uploadFieldName;

    /**
     * @var string
     *
     * View image url name
     */
    private $viewImageRouteName;

    /**
     * @var string
     *
     * Resize image url name
     */
    private $resizeImageRouteName;

    /**
     * Image uploader.
     *
     * @param RequestStack    $requestStack         Request stack
     * @param ImageUploader   $imageUploader        Image uploader
     * @param RouterInterface $router               Router
     * @param string          $uploadFieldName      Field name when uploading
     * @param string          $viewImageRouteName   View image url name
     * @param string          $resizeImageRouteName Resize image url name
     */
    public function __construct(
        RequestStack $requestStack,
        ImageUploader $imageUploader,
        RouterInterface $router,
        $uploadFieldName,
        $viewImageRouteName,
        $resizeImageRouteName
    ) {
        $this->requestStack = $requestStack;
        $this->imageUploader = $imageUploader;
        $this->router = $router;
        $this->uploadFieldName = $uploadFieldName;
        $this->viewImageRouteName = $viewImageRouteName;
        $this->resizeImageRouteName = $resizeImageRouteName;
    }

    /**
     * Dynamic upload action.
     *
     * @return JsonResponse Upload response
     */
    public function uploadAction()
    {
        $request = $this
            ->requestStack
            ->getCurrentRequest();

        /**
         * @var UploadedFile $file
         */
        $file = $request
            ->files
            ->get($this->uploadFieldName);

        if (!($file instanceof UploadedFile)) {
            return new JsonResponse([
                'status' => 'ko',
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
                'status' => 'ok',
                'response' => [
                    'id' => $image->getId(),
                    'extension' => $image->getExtension(),
                    'routes' => [
                        'view' => $routes
                            ->get($this->viewImageRouteName)
                            ->getPath(),
                        'resize' => $routes
                            ->get($this->resizeImageRouteName)
                            ->getPath(),
                    ],
                ],
            ];
        } catch (Exception $exception) {
            $response = [
                'status' => 'ko',
                'response' => [
                    'message' => $exception->getMessage(),
                ],
            ];
        }

        return new JsonResponse($response);
    }
}
