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
use Symfony\Component\HttpFoundation\Response;

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
     * Construct
     *
     * @param LocationManagerInterface $locationManager Location manager
     */
    public function __construct(LocationManagerInterface $locationManager)
    {
        $this->locationManager = $locationManager;
    }

    /**
     * Get all the root locations.
     *
     * @return Response Data serialized in json
     */
    public function getRootLocationsAction()
    {
        $locations = $this
            ->locationManager
            ->getRootLocations();

        return new Response(json_encode($locations));
    }

    /**
     * Get the children given a location id.
     *
     * @param string $id The location Id
     *
     * @return Response Data serialized in json
     */
    public function getChildrenAction($id)
    {
        $locations = $this
            ->locationManager
            ->getChildren($id);

        return new Response(json_encode($locations));
    }

    /**
     * Get the parents given a location id.
     *
     * @param string $id The location Id
     *
     * @return Response Data serialized in json
     */
    public function getParentsAction($id)
    {
        $locations = $this
            ->locationManager
            ->getParents($id);

        return new Response(json_encode($locations));
    }

    /**
     * Get the full location info given it's id.
     *
     * @param string $id The location Id
     *
     * @return Response Data serialized in json
     */
    public function getLocationAction($id)
    {
        $locations = $this
            ->locationManager
            ->getLocation($id);

        return new Response(json_encode($locations));
    }

    /**
     * Get the hierarchy given a location sorted from root to the given
     * location.
     *
     * @param string $id The location Id
     *
     * @return Response Data serialized in json
     */
    public function getHierarchyAction($id)
    {
        $locations = $this
            ->locationManager
            ->getHierarchy($id);

        return new Response(json_encode($locations));
    }

    /**
     * Checks if the first received id is contained between the rest of ids
     * received as second parameter
     *
     * @param string $id  The location Id
     * @param string $ids The location Ids separated by commas
     *
     * @return Response Data serialized in json
     */
    public function inAction($id, $ids)
    {
        $locations = $this
            ->locationManager
            ->in($id, explode(',', $ids));

        return new Response(json_encode($locations));
    }
}
