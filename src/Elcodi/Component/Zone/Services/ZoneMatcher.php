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

namespace Elcodi\Component\Zone\Services;

use Exception;

use Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface;

/**
 * Class ZoneMatcher.
 */
class ZoneMatcher
{
    /**
     * @var LocationProviderAdapterInterface
     *
     * Location manager
     */
    protected $locationProvider;

    /**
     * Construct.
     *
     * @param LocationProviderAdapterInterface $locationProvider Location manager
     */
    public function __construct(LocationProviderAdapterInterface $locationProvider)
    {
        $this->locationProvider = $locationProvider;
    }

    /**
     * Checks if an specific Address is contained in a Zone. For an Address, to
     * be contained in a Zone means that belongs to one (at least) of this Zone
     * locations.
     *
     * @param AddressInterface $address Address
     * @param ZoneInterface    $zone    Zone
     *
     * @return bool Address is contained in zone
     */
    public function isAddressContainedInZone(
        AddressInterface $address,
        ZoneInterface $zone
    ) {
        $locations = $zone->getLocations();
        $cityId = $address->getCity();
        $found = false;

        try {
            $found = $this
                ->locationProvider
                ->in($cityId, $locations);
        } catch (Exception $e) {

            // Silent pass
        }

        return $found;
    }
}
