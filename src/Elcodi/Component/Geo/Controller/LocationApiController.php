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

namespace Elcodi\Component\Geo\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Geo\Services\Interfaces\LocationproviderInterface;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class LocationApiController
 */
class LocationApiController
{
    /**
     * @var LocationproviderInterface
     *
     * Location manager
     */
    protected $locationprovider;

    /**
     * @var Request
     *
     * Request
     */
    protected $request;

    /**
     * Construct
     *
     * @param RequestStack              $requestStack     Request stack
     * @param LocationproviderInterface $locationprovider Location manager
     */
    public function __construct(
        RequestStack $requestStack,
        LocationproviderInterface $locationprovider
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->locationprovider = $locationprovider;
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
                        ->locationprovider
                        ->getRootLocations()
                );
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
            return $this->normalizeLocationDataArray(
                $this
                    ->locationprovider
                    ->getChildren($id)
            );
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
            return $this->normalizeLocationDataArray(
                $this
                    ->locationprovider
                    ->getParents($id)
            );
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
            return $this->normalizeLocationData(
                $this
                    ->locationprovider
                    ->getLocation($id)
            );
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
            return $this->normalizeLocationDataArray(
                $this
                    ->locationprovider
                    ->getHierarchy($id)
            );
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
                ->locationprovider
                ->in($id, $ids);
        });
    }

    /**
     * Create new response
     *
     * @param Callable $callable Callable
     *
     * @return Response Response object
     */
    protected function createResponseObject(callable $callable)
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
     * Normalize an array of LocationData objects to be json encoded
     *
     * @param LocationData[] $locationDataArray Location data array
     *
     * @return array Data normalized
     */
    protected function normalizeLocationDataArray(array $locationDataArray)
    {
        $normalizedLocationDataArray = [];

        foreach ($locationDataArray as $locationData) {
            $normalizedLocationDataArray[] = $this
                ->normalizeLocationData($locationData);
        }

        return $normalizedLocationDataArray;
    }

    /**
     * Normalize LocationData object to be json encoded
     *
     * @param LocationData $locationData Location data
     *
     * @return array Data normalized
     */
    protected function normalizeLocationData(LocationData $locationData)
    {
        return [
            'id'   => $locationData->getId(),
            'name' => $locationData->getName(),
            'code' => $locationData->getCode(),
            'type' => $locationData->getType(),
        ];
    }
}
