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

namespace Elcodi\Component\Geo\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class LocationApiController.
 */
class LocationApiController
{
    /**
     * @var LocationProviderAdapterInterface
     *
     * Location manager
     */
    private $locationProvider;

    /**
     * @var Request
     *
     * Request
     */
    private $request;

    /**
     * Construct.
     *
     * @param RequestStack                     $requestStack     Request stack
     * @param LocationProviderAdapterInterface $locationProvider Location manager
     */
    public function __construct(
        RequestStack $requestStack,
        LocationProviderAdapterInterface $locationProvider
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->locationProvider = $locationProvider;
    }

    /**
     * Get all the root locations.
     *
     * @return Response Data serialized in json
     */
    public function getRootLocationsAction()
    {
        return $this->createResponseObject(function () {
            return
                $this->normalizeLocationDataArray(
                    $this
                        ->locationProvider
                        ->getRootLocations()
                );
        });
    }

    /**
     * Get the children given a location id.
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
            return $this->normalizeLocationDataArray(
                $this
                    ->locationProvider
                    ->getChildren($id)
            );
        });
    }

    /**
     * Get the parents given a location id.
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
            return $this->normalizeLocationDataArray(
                $this
                    ->locationProvider
                    ->getParents($id)
            );
        });
    }

    /**
     * Get the full location info given it's id.
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
            return $this->normalizeLocationData(
                $this
                    ->locationProvider
                    ->getLocation($id)
            );
        });
    }

    /**
     * Get the hierarchy given a location sorted from root to the given
     * location.
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
            return $this->normalizeLocationDataArray(
                $this
                    ->locationProvider
                    ->getHierarchy($id)
            );
        });
    }

    /**
     * Checks if the first received id is contained between the rest of ids
     * received as second parameter.
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

        $result = $this
                ->locationProvider
                ->in($id, $ids);

        return $this->createResponseObject(function () use ($result) {
            return ['result' => $result];
        });
    }

    /**
     * Create new response.
     *
     * @param callable $callable Callable
     *
     * @return Response Response object
     */
    private function createResponseObject(callable $callable)
    {
        try {
            $response = new JsonResponse($callable());
        } catch (EntityNotFoundException $notFoundException) {
            $response = new JsonResponse(
                $notFoundException->getMessage(),
                404
            );
        } catch (Exception $e) {
            $response = new JsonResponse(
                'API exception. Please contact your webmaster',
                500
            );
        }

        return $response;
    }

    /**
     * Normalize an array of LocationData objects to be json encoded.
     *
     * @param LocationData[] $locationDataArray Location data array
     *
     * @return array Data normalized
     */
    private function normalizeLocationDataArray(array $locationDataArray)
    {
        $normalizedLocationDataArray = [];

        foreach ($locationDataArray as $locationData) {
            $normalizedLocationDataArray[] = $this
                ->normalizeLocationData($locationData);
        }

        return $normalizedLocationDataArray;
    }

    /**
     * Normalize LocationData object to be json encoded.
     *
     * @param LocationData $locationData Location data
     *
     * @return array Data normalized
     */
    private function normalizeLocationData(LocationData $locationData)
    {
        return [
            'id' => $locationData->getId(),
            'name' => $locationData->getName(),
            'code' => $locationData->getCode(),
            'type' => $locationData->getType(),
        ];
    }
}
