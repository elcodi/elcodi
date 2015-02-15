<?php

namespace Elcodi\Component\Geo\Services\Interfaces;

use Elcodi\Component\Geo\Services\Interfaces\LocationIdentifiedCollectionInterface;

/**
 * Interface LocationManagerInterface
 */
interface LocationManagerInterface
{
    /**
     * Get all the root locations.
     *
     * @return [LocationIdentifiedCollectionInterface]
     */
    public function getRootLocations();

    /**
     * Get the children given a location id.
     *
     * @param string|array $ids The location Ids or a single id.
     *
     * @return [LocationIdentifiedCollectionInterface]
     */
    public function getChildren($ids);

    /**
     * Get the parents given a location id.
     *
     * @param string|array $ids The location Ids or a single id.
     *
     * @return [LocationIdentifiedCollectionInterface]
     */
    public function getParents($ids);

    /**
     * Get the full location info given it's id.
     *
     * @param string|array $ids The location Ids or a single id.
     *
     * @return LocationIdentifiedCollectionInterface
     */
    public function getLocation($ids);

    /**
     * Get the hierarchy given a location sorted from root to the given location.
     *
     * @param string|array $ids The location Ids or a single id.
     *
     * @return [LocationIdentifiedCollectionInterface]
     */
    public function getHierarchy($ids);

    /**
     * Checks if the first received id is contained between the rest of ids received as second parameter
     *
     * @param string $id  The location Id
     * @param array  $ids The location Ids
     *
     * @return boolean
     */
    public function in($id, array $ids);
}