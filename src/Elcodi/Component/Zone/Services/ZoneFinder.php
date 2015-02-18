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
use Elcodi\Component\Zone\Repository\ZoneRepository;

/**
 * Class ZoneFinder
 */
class ZoneFinder
{
    /**
     * @var ZoneRepository
     *
     * Zone repository
     */
    protected $zoneRepository;

    /**
     * @var ZoneMatcher
     *
     * Zone matcher
     */
    protected $zoneMatcher;

    /**
     * Construct
     *
     * @param ZoneRepository $zoneRepository Zone repository
     * @param ZoneMatcher    $zoneMatcher    Zone matcher
     */
    public function __construct(
        ZoneRepository $zoneRepository,
        ZoneMatcher $zoneMatcher
    ) {
        $this->zoneRepository = $zoneRepository;
        $this->zoneMatcher = $zoneMatcher;
    }

    /**
     * Get all zones where the address is included in
     *
     * @param AddressInterface $address Address
     *
     * @return boolean Zones where address is contained
     */
    public function getZonesFromAddress(AddressInterface $address)
    {
        return $this
            ->zoneRepository
            ->getActiveZones()
            ->filter(function (ZoneInterface $zone) use ($address) {

                return $this
                    ->zoneMatcher
                    ->isAddressContainedInZone(
                        $address,
                        $zone
                    );
            });
    }
}
