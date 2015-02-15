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

use Doctrine\Common\Collections\ArrayCollection;

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

    /**
     * Get all zones where the address is included in
     *
     * @param ZoneInterface    $zone    Zone
     * @param AddressInterface $address Address
     *
     * @return boolean Zones where address is contained
     */
    public function getZonesFromAddress(
        ZoneInterface $zone,
        AddressInterface $address
    ) {
        $city = $address->getCity();
        $zones = array_merge(
            [],
            $this->getZonesFromCountry($zone, $city->getCountry())->toArray(),
            $this->getZonesFromState($zone, $city->getState())->toArray(),
            $this->getZonesFromProvince($zone, $city->getProvince())->toArray(),
            $this->getZonesFromCity($zone, $city)->toArray(),
            $this->getZonesFromPostalCode($zone, $address->getPostalcode())->toArray()
        );

        return new ArrayCollection($zones);
    }
}
