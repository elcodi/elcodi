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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Zone\Services;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Services\Interfaces\LocationManagerInterface;

/**
 * Class ZoneMatcher
 */
class ZoneMatcher
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
     * Checks if an specific Address is contained in a Zone. For an Address, to
     * be contained in a Zone means that belongs to one (at least) of this Zone
     * locations.
     *
     * @param AddressInterface $address Address
     * @param ZoneInterface    $zone    Zone
     *
     * @return boolean Address is contained in zone
     */
    public function isAddressContainedInZone(
        AddressInterface $address,
        ZoneInterface $zone
    )
    {
        $locations = $zone->getLocations();
        $isContained = false;

        foreach ($locations as $location) {

            $isContained |= $this
                ->locationManager
                ->in(
                    $address->getId(),
                    $location
                );
        }

        return $isContained;
    }
}
