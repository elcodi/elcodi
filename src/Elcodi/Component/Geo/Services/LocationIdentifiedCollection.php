<?php

namespace Elcodi\Component\Geo\Services;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Services\Interfaces\LocationIdentifiedCollectionInterface;

/**
 * Class LocationIdentifiedCollection
 */
class LocationIdentifiedCollection implements LocationIdentifiedCollectionInterface
{
    /**
     * @var string
     *
     * The collection identifier
     */
    protected $id;

    /**
     * @var [LocationInterface]
     *
     * The collection locations
     */
    protected $locations;

    /**
     * Gets the id
     *
     * @return string The id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id.
     *
     * @param string $id The id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the locations
     *
     * @return [LocationInterface]
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Sets the locations
     *
     * @param [LocationInterface] $locations
     *
     * @return $this Self object
     */
    public function setLocations(array $locations)
    {
        $this->locations = $locations;

        return $this;
    }

    /**
     * Adds a location
     *
     * @param LocationInterface $location The location to add
     *
     * @return $this
     */
    public function addLocation(LocationInterface $location)
    {
        $this->locations[$location->getId()] = $location;

        return $this;
    }
}
