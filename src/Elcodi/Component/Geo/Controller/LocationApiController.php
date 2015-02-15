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

namespace Elcodi\Component\Geo\Controller;

use Elcodi\Component\Geo\Services\Interfaces\LocationManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

/**
 * Class LocationApiController
 */
class LocationApiController
{
    /**
     * @var LocationManagerInterface
     *
     * Location manager
     */
    protected $locationManager;

    /**
     * @var Request
     *
     * Request
     */
    protected $request;

    /**
     * Construct
     *
     * @param RequestStack             $requestStack    Request stack
     * @param LocationManagerInterface $locationManager Location manager
     */
    public function __construct(
        RequestStack $requestStack,
        LocationManagerInterface $locationManager
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->locationManager = $locationManager;
    }

    /**
     * Get all the root locations.
     *
     * @return Response Data serialized in json
     */
    public function getRootLocationsAction()
    {
        return $this->createResponseObject(function () {
            return $this
                ->locationManager
                ->getRootLocations();
        });
    }

    /**
     * Get the children given a location id
     *
     * @return Response Data serialized in json
     */
    public function getChildrenAction()
    {
        $id = $this
            ->request
            ->query
            ->get('id');

        return $this->createResponseObject(function () use ($id) {
            return $this
                ->locationManager
                ->getChildren($id);
        });
    }

    /**
     * Get the parents given a location id
     *
     * @return Response Data serialized in json
     */
    public function getParentsAction()
    {
        $id = $this
            ->request
            ->query
            ->get('id');

        return $this->createResponseObject(function () use ($id) {
            return $this
                ->locationManager
                ->getParents($id);
        });
    }

    /**
     * Get the full location info given it's id
     *
     * @return Response Data serialized in json
     */
    public function getLocationAction()
    {
        $id = $this
            ->request
            ->query
            ->get('id');

        return $this->createResponseObject(function () use ($id) {
            return $this
                ->locationManager
                ->getLocation($id);
        });
    }

    /**
     * Get the hierarchy given a location sorted from root to the given
     * location
     *
     * @return Response Data serialized in json
     */
    public function getHierarchyAction()
    {
        $id = $this
            ->request
            ->query
            ->get('id');

        return $this->createResponseObject(function () use ($id) {
            return $this
                ->locationManager
                ->getHierarchy($id);
        });
    }

    /**
     * Checks if the first received id is contained between the rest of ids
     * received as second parameter
     *
     * @return Response Data serialized in json
     */
    public function inAction()
    {
        $id = $this
            ->request
            ->query
            ->get('id');

        $ids = explode(',', $this
            ->request
            ->query
            ->get('ids'));

        return $this->createResponseObject(function () use ($id, $ids) {
            return $this
                ->locationManager
                ->getChildren($id, $ids);
        });
    }

    /**
     * Create new response
     *
     * @param Callable $callable Callable
     *
     * @return Response Response object
     */
    protected function createResponseObject(Callable $callable)
    {
        try {
            $response = new JsonResponse(
                json_encode($callable())
            );

        } catch (NotFoundHttpException $notFoundException) {

            $response = new Response(
                $notFoundException->getMessage(),
                404
            );

        } catch (Exception $e) {

            $response = new Response(
                'Exception',
                500
            );
        }

        return $response;
    }
}
