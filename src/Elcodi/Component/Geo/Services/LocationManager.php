<?php

namespace Elcodi\Component\Geo\Services;

use Doctrine\ORM\EntityNotFoundException;
use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Factory\LocationDataFactory;
use Elcodi\Component\Geo\ValueObject\LocationData;
use Elcodi\Component\Geo\Services\Interfaces\LocationManagerInterface;
use Elcodi\Component\Geo\Repository\LocationRepository;

class LocationManager implements LocationManagerInterface
{
    /**
     * @var EntityRepositor
     */
    protected $locationRepository;

    /**
     * @var LocationDataFactory
     */
    protected $locationDataFactory;

    public function __construct(
        LocationRepository $locationRepository,
        LocationDataFactory $locationDataFactory
    ) {
        $this->locationRepository  = $locationRepository;
        $this->locationDataFactory = $locationDataFactory;
    }

    /**
     * Get all the root locations.
     *
     * @return LocationData[]
     */
    public function getRootLocations()
    {
        $roots = $this
            ->locationRepository
            ->findAllRoots();

        return $this->formatOutput($roots);
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
        $location = $this
            ->locationRepository
            ->findOneBy([
                'id' => $id
            ]);

        if (empty($location)) {
            throw new EntityNotFoundException();
        }

        return $this->formatOutput(
            $location->getChildren()
        );
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
        $location = $this->locationRepository->findOneBy(['id' => $id]);

        if (empty($location)) {
            throw new EntityNotFoundException();
        }

        return $this->formatOutput(
            $location->getParents()
        );
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
        $location = $this->locationRepository->findOneBy(['id' => $id]);

        if (empty($location)) {
            throw new EntityNotFoundException();
        }

        return $this->formatOutput($location);
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
        $location = $this->locationRepository->findOneBy(['id' => $id]);

        if (empty($location)) {
            throw new EntityNotFoundException();
        }

        $addedNodes = [];
        $hierarchy  = $this->getLocationHierarchyRecursively(
            $location,
            $addedNodes
        );

        return $this->formatOutput(array_reverse($hierarchy));
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
        $found         = false;
        $searchedNodes = [];
        foreach ($ids as $searchId) {
            $location = $this->locationRepository->findOneBy(['id' => $searchId]);

            $this->inHierarchyRecursively(
                $id,
                $location,
                $searchedNodes,
                $found
            );

            if ($found) {
                return true;
            }
        }

        return false;
    }

    protected function inHierarchyRecursively(
        $id,
        LocationInterface $location,
        array &$searchedNodes,
        &$found
    ) {
        if (
            $found
            || in_array($location->getId(), $searchedNodes)
        ) {
            return;
        }

        if ($id == $location->getId()) {
            $found = true;
            return;
        }

        $searchedNodes[] = $location->getId();

        $parents = $location->getChildren();

        if (!empty($parents)) {
            foreach ($parents as $parent) {
                $this->inHierarchyRecursively(
                    $id,
                    $parent,
                    $searchedNodes,
                    $found
                );
            }
        }

        return;
    }

    protected function getLocationHierarchyRecursively(
        LocationInterface $location,
        array &$addedNodes
    ) {
        if (in_array($location->getId(), $addedNodes)) {
            return [];
        }

        $hierarchy = [$location];
        $parents   = $location->getParents();

        if (!empty($parents)) {
            foreach ($parents as $parent) {
                $hierarchy = array_merge(
                    $hierarchy,
                    $this->getLocationHierarchyRecursively(
                        $parent,
                        $addedNodes
                    )
                );
            }
        }

        return $hierarchy;
    }

    /**
     * @param LocationInterface|array $locations The locations to format.
     *
     * @return array
     */
    protected function formatOutput($locations)
    {
        if ($locations instanceof LocationInterface) {
            return $this
                ->locationDataFactory
                ->create(
                    $locations->getId(),
                    $locations->getName(),
                    $locations->getCode(),
                    $locations->getType()
                );
        }

        $formattedResponse = [];
        foreach ($locations as $location) {
            $formattedResponse[] =
                $this
                    ->locationDataFactory
                    ->create(
                        $location->getId(),
                        $location->getName(),
                        $location->getCode(),
                        $location->getType()
                    );
        }
        return $formattedResponse;
    }
}