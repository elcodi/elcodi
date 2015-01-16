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
 */

namespace Elcodi\Component\Geo\Services;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneCountryMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZonePostalCodeMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneProvinceMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneStateMemberInterface;

/**
 * Class ZoneMatcher
 */
class ZoneMatcher
{
    /**
     * @param ZoneInterface    $zone
     * @param AddressInterface $address
     *
     * @return boolean Address is contained in zone
     */
    public function isAddressContainedInZone(
        ZoneInterface $zone,
        AddressInterface $address
    )
    {
        $city = $address->getCity();

        return
            $this->isCountryContainedInZone($zone, $city->getCountry()) |
            $this->isStateContainedInZone($zone, $city->getState()) |
            $this->isProvinceContainedInZone($zone, $city->getProvince()) |
            $this->isCityContainedInZone($zone, $address->getCity()) |
            $this->isPostalCodeContainedInZone($zone, $address->getPostalcode());
    }

    /**
     * @param ZoneInterface    $zone
     * @param CountryInterface $country
     *
     * @return boolean Country is contained in zone
     */
    public function isCountryContainedInZone(
        ZoneInterface $zone,
        CountryInterface $country
    )
    {
        return $zone
            ->getMembers()
            ->filter(function (ZoneMemberInterface $zoneMember) {
                return $zoneMember instanceof ZoneCountryMemberInterface;
            })
            ->exists(function ($_, ZoneCountryMemberInterface $zoneCountryMember) use ($country) {
                return $country
                    ->equals($zoneCountryMember
                            ->getCountry()
                    );
            });
    }

    /**
     * @param ZoneInterface  $zone
     * @param StateInterface $state
     *
     * @return boolean State is contained in zone
     */
    public function isStateContainedInZone(
        ZoneInterface $zone,
        StateInterface $state
    )
    {
        return $zone
            ->getMembers()
            ->filter(function (ZoneMemberInterface $zoneMember) {
                return $zoneMember instanceof ZoneStateMemberInterface;
            })
            ->exists(function ($_, ZoneStateMemberInterface $zoneStateMember) use ($state) {
                return $state
                    ->equals($zoneStateMember
                            ->getState()
                    );
            });
    }

    /**
     * @param ZoneInterface     $zone
     * @param ProvinceInterface $province
     *
     * @return boolean Province is contained in zone
     */
    public function isProvinceContainedInZone(
        ZoneInterface $zone,
        ProvinceInterface $province
    )
    {
        return $zone
            ->getMembers()
            ->filter(function (ZoneMemberInterface $zoneMember) {
                return $zoneMember instanceof ZoneProvinceMemberInterface;
            })
            ->exists(function ($_, ZoneProvinceMemberInterface $zoneProvinceMember) use ($province) {
                return $province
                    ->equals($zoneProvinceMember
                            ->getProvince()
                    );
            });
    }

    /**
     * @param ZoneInterface $zone
     * @param CityInterface $city
     *
     * @return boolean City is contained in zone
     */
    public function isCityContainedInZone(
        ZoneInterface $zone,
        CityInterface $city
    )
    {
        return $zone
            ->getMembers()
            ->filter(function (ZoneMemberInterface $zoneMember) {
                return $zoneMember instanceof ZoneCityMemberInterface;
            })
            ->exists(function ($_, ZoneCityMemberInterface $zoneCityMember) use ($city) {
                return $city
                    ->equals($zoneCityMember
                            ->getCity()
                    );
            });
    }

    /**
     * @param ZoneInterface       $zone
     * @param PostalCodeInterface $postalCode
     *
     * @return boolean PostalCode is contained in zone
     */
    public function isPostalCodeContainedInZone(
        ZoneInterface $zone,
        PostalCodeInterface $postalCode
    )
    {
        return $zone
            ->getMembers()
            ->filter(function (ZoneMemberInterface $zoneMember) {
                return $zoneMember instanceof ZonePostalCodeMemberInterface;
            })
            ->exists(function ($_, ZonePostalcodeMemberInterface $zonePostalCodeMember) use ($postalCode) {
                return $postalCode
                    ->equals($zonePostalCodeMember
                            ->getPostalcode()
                    );
            });
    }
}
