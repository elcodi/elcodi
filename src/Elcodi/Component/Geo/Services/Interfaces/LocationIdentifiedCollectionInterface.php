<?php

namespace Elcodi\Component\Geo\Services\Interfaces;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;

/**
 * Class LocationIdentifiedCollectionInterface
 */
interface LocationIdentifiedCollectionInterface
{
    /**
     * Gets the id
     *
     * @return string The id
     */
    public function getId();

    /**
     * Sets the id.
     *
     * @param string $id The id
     *
     * @return $this Self object
     */
    public function setId($id);

    /**
     * Gets the locations
     *
     * @return [LocationInterface]
     */
    public function getLocations();

    /**
     * Sets the locations
     *
     * @param [LocationInterface] $locations
     *
     * @return $this Self object
     */
    public function setLocations(array $locations);

    /**
     * Adds a location
     *
     * @param LocationInterface $location The location to add
     *
     * @return $this
     */
    public function addLocation(LocationInterface $location);
}
