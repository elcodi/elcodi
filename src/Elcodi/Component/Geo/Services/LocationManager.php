<?php

namespace Elcodi\Component\Geo\Services;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\LocationData\LocationData;
use Elcodi\Component\Geo\Services\Interfaces\LocationManagerInterface;
use Elcodi\Component\Geo\Repository\LocationRepository;

class LocationManager implements LocationManagerInterface
{
    /**
     * @var EntityRepositor
     */
    private $locationRepository;

    public function __construct(
        LocationRepository $locationRepository
    ) {
        $this->locationRepository = $locationRepository;
    }

    /**
     * Get all the root locations.
     *
     * @return LocationData[]
     */
    public function getRootLocations()
    {
        return $this->locationRepository->findAllRoots();
    }

    /**
     * Get the children given a location id.
     *
     * @param string $id The location Id.
     *
     * @return LocationData[]
     */
    public function getChildren($id)
    {
        $parent = $this->locationRepository->findOneBy(['id'=>$id]);
        return $parent->getChildren();
    }

    /**
     * Get the parents given a location id.
     *
     * @param string $id The location Id.
     *
     * @return LocationData[]
     */
    public function getParents($id)
    {
        $parent = $this->locationRepository->findOneBy(['id'=>$id]);
        return $parent->getParents();
    }

    /**
     * Get the full location info given it's id.
     *
     * @param string $id The location id.
     *
     * @return LocationData
     */
    public function getLocation($id)
    {
        // TODO: Implement getLocation() method.
    }

    /**
     * Get the hierarchy given a location sorted from root to the given
     * location.
     *
     * @param string $id The location id.
     *
     * @return LocationData
     */
    public function getHierarchy($id)
    {
        // TODO: Implement getHierarchy() method.
    }

    /**
     * Checks if the first received id is contained between the rest of ids
     * received as second parameter
     *
     * @param string $id  The location Id
     * @param array  $ids The location Ids
     *
     * @return boolean
     */
    public function in($id, array $ids)
    {
        // TODO: Implement in() method.
    }
}