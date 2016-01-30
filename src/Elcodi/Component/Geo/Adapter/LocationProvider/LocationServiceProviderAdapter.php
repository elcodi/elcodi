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

namespace Elcodi\Component\Geo\Adapter\LocationProvider;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityNotFoundException;

use Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface;
use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Repository\LocationRepository;
use Elcodi\Component\Geo\Transformer\LocationToLocationDataTransformer;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class LocationServiceProviderAdapter.
 */
class LocationServiceProviderAdapter implements LocationProviderAdapterInterface
{
    /**
     * @var LocationRepository
     *
     * Location repository
     */
    private $locationRepository;

    /**
     * @var LocationToLocationDataTransformer
     *
     * LocationToLocationData transformer
     */
    private $locationToLocationDataTransformer;

    /**
     * Construct.
     *
     * @param LocationRepository                $locationRepository                Location repository
     * @param LocationToLocationDataTransformer $locationToLocationDataTransformer LocationToLocationData transformer
     */
    public function __construct(
        LocationRepository $locationRepository,
        LocationToLocationDataTransformer $locationToLocationDataTransformer
    ) {
        $this->locationRepository = $locationRepository;
        $this->locationToLocationDataTransformer = $locationToLocationDataTransformer;
    }

    /**
     * Get all the root locations.
     *
     * @return LocationData[] Collection of locations
     */
    public function getRootLocations()
    {
        $roots = $this
            ->locationRepository
            ->findAllRoots();

        return $this->formatOutputLocationArray($roots);
    }

    /**
     * Get the children given a location id.
     *
     * @param string $id The location Id.
     *
     * @return LocationData[] Collection of locations
     *
     * @throws EntityNotFoundException Entity not found
     */
    public function getChildren($id)
    {
        $location = $this
            ->locationRepository
            ->findOneBy([
                'id' => $id,
            ]);

        if (empty($location)) {
            throw new EntityNotFoundException();
        }

        return $this->formatOutputLocationArray(
            $location->getChildren()
        );
    }

    /**
     * Get the parents given a location id.
     *
     * @param string $id The location Id.
     *
     * @return LocationData[] Collection of locations
     *
     * @throws EntityNotFoundException Entity not found
     */
    public function getParents($id)
    {
        $location = $this
            ->locationRepository
            ->findOneBy([
                'id' => $id,
            ]);

        if (empty($location)) {
            throw new EntityNotFoundException();
        }

        return $this->formatOutputLocationArray(
            $location->getParents()
        );
    }

    /**
     * Get the full location info given it's id.
     *
     * @param string $id The location id.
     *
     * @return LocationData Location info
     *
     * @throws EntityNotFoundException Entity not found
     */
    public function getLocation($id)
    {
        /**
         * @var LocationInterface $location
         */
        $location = $this
            ->locationRepository
            ->findOneBy([
                'id' => $id,
            ]);

        if (!($location instanceof LocationInterface)) {
            throw new EntityNotFoundException();
        }

        return $this->formatOutputLocation($location);
    }

    /**
     * Get the hierarchy given a location sorted from root to the given
     * location.
     *
     * @param string $id The location id.
     *
     * @return LocationData[] Collection of locations
     *
     * @throws EntityNotFoundException Entity not found
     */
    public function getHierarchy($id)
    {
        $location = $this
            ->locationRepository
            ->findOneBy([
                'id' => $id,
            ]);

        if (empty($location)) {
            throw new EntityNotFoundException();
        }

        $parents = $location->getAllParents();
        $hierarchy = array_merge(
            $parents,
            [$location]
        );

        return $this->formatOutputLocationArray(
            $hierarchy
        );
    }

    /**
     * Checks if the first received id is contained between the rest of ids
     * received as second parameter.
     *
     * @param string $id  The location Id
     * @param array  $ids The location Ids
     *
     * @return bool Location is container
     */
    public function in($id, array $ids)
    {
        $allParents = $this->getHierarchy($id);

        /**
         * To increase the efficiency, we can index the results of the parent.
         */
        $allParentsIndexed = [];
        foreach ($allParents as $parent) {
            $allParentsIndexed[$parent->getId()] = $parent;
        }

        foreach ($ids as $possibleParentId) {
            if (isset($allParentsIndexed[$possibleParentId])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Given a group of locations, return a simplified output using the
     * ValueObject LocationData, ready to be serialized.
     *
     * @param array|Collection $locations The locations to format.
     *
     * @return LocationData[] Formatted mode of Locations
     */
    private function formatOutputLocationArray($locations)
    {
        $formattedResponse = [];

        /**
         * @var LocationInterface $location
         */
        foreach ($locations as $location) {
            $formattedResponse[] = $this->formatOutputLocation($location);
        }

        return $formattedResponse;
    }

    /**
     * Given a location, return a simplified output using the
     * ValueObject LocationData, ready to be serialized.
     *
     * @param LocationInterface $location The location to format.
     *
     * @return LocationData Formatted mode of Location
     */
    private function formatOutputLocation(LocationInterface $location)
    {
        return $this
            ->locationToLocationDataTransformer
            ->transform($location);
    }
}
