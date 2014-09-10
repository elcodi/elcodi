<?php

/**
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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneCountryMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZonePostalCodeMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneProvinceMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneStateMemberInterface;
use Elcodi\Component\Geo\Repository\ZoneCityMemberRepository;
use Elcodi\Component\Geo\Repository\ZoneCountryMemberRepository;
use Elcodi\Component\Geo\Repository\ZonePostalCodeMemberRepository;
use Elcodi\Component\Geo\Repository\ZoneProvinceMemberRepository;
use Elcodi\Component\Geo\Repository\ZoneStateMemberRepository;

/**
 * Class ZoneFinder
 */
class ZoneFinder
{
    /**
     * @var ZoneCountryMemberRepository
     *
     * ZoneCountryMember repository
     */
    protected $zoneCountryMemberRepository;

    /**
     * @var ZoneStateMemberRepository
     *
     * ZoneStateMember repository
     */
    protected $zoneStateMemberRepository;

    /**
     * @var ZoneProvinceMemberRepository
     *
     * ZoneProvinceMember repository
     */
    protected $zoneProvinceMemberRepository;

    /**
     * @var ZoneCityMemberRepository
     *
     * ZoneCityMember repository
     */
    protected $zoneCityMemberRepository;

    /**
     * @var ZonePostalCodeMemberRepository
     *
     * ZonePostalCodeMember repository
     */
    protected $zonePostalCodeMemberRepository;

    /**
     * Constructor
     *
     * @param ZoneCountryMemberRepository    $zoneCountryMemberRepository    ZoneCountryMember repository
     * @param ZoneStateMemberRepository      $zoneStateMemberRepository      ZoneStateMember repository
     * @param ZoneProvinceMemberRepository   $zoneProvinceMemberRepository   ZoneProvinceMember repository
     * @param ZoneCityMemberRepository       $zoneCityMemberRepository       ZoneCityMember repository
     * @param ZonePostalCodeMemberRepository $zonePostalCodeMemberRepository ZonePostalCodeMember repository
     */
    public function __construct(
        ZoneCountryMemberRepository $zoneCountryMemberRepository,
        ZoneStateMemberRepository $zoneStateMemberRepository,
        ZoneProvinceMemberRepository $zoneProvinceMemberRepository,
        ZoneCityMemberRepository $zoneCityMemberRepository,
        ZonePostalCodeMemberRepository $zonePostalCodeMemberRepository
    )
    {
        $this->zoneCountryMemberRepository = $zoneCountryMemberRepository;
        $this->zoneStateMemberRepository = $zoneStateMemberRepository;
        $this->zoneProvinceMemberRepository = $zoneProvinceMemberRepository;
        $this->zoneCityMemberRepository = $zoneCityMemberRepository;
        $this->zonePostalCodeMemberRepository = $zonePostalCodeMemberRepository;
    }

    /**
     * Get all zones where the address is included in
     *
     * @param ZoneInterface    $zone    Zone
     * @param AddressInterface $address Address
     *
     * @return boolean Address is contained in zone
     */
    public function getZonesFromAddress(
        ZoneInterface $zone,
        AddressInterface $address
    )
    {
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

    /**
     * Get all zones where the country is included in
     *
     * @param ZoneInterface    $zone    Zone
     * @param CountryInterface $country Country
     *
     * @return Collection
     */
    public function getZonesFromCountry(
        $zone, $country
    )
    {
        $zones = new ArrayCollection();
        $zoneMembers = $this
            ->zoneCountryMemberRepository
            ->findBy([
                'zone'    => $zone,
                'country' => $country,
            ]);

        if (is_array($zoneMembers) && !empty($zoneMembers)) {

            array_walk($zoneMembers, function (ZoneCountryMemberInterface $zoneCountryMember) use ($zones) {

                $zones->add($zoneCountryMember->getZone());
            });
        }

        return $zones;
    }

    /**
     * Get all zones where the state is included in
     *
     * @param ZoneInterface  $zone  Zone
     * @param StateInterface $state State
     *
     * @return Collection
     */
    public function getZonesFromState(
        $zone, $state
    )
    {
        $zones = new ArrayCollection();
        $zoneMembers = $this
            ->zoneStateMemberRepository
            ->findBy([
                'zone'  => $zone,
                'state' => $state,
            ]);

        if (is_array($zoneMembers) && !empty($zoneMembers)) {

            array_walk($zoneMembers, function (ZoneStateMemberInterface $zoneStateMember) use ($zones) {

                $zones->add($zoneStateMember->getZone());
            });
        }

        return $zones;
    }

    /**
     * Get all zones where the province is included in
     *
     * @param ZoneInterface     $zone     Zone
     * @param ProvinceInterface $province Province
     *
     * @return Collection
     */
    public function getZonesFromProvince(
        $zone, $province
    )
    {
        $zones = new ArrayCollection();
        $zoneMembers = $this
            ->zoneProvinceMemberRepository
            ->findBy([
                'zone'     => $zone,
                'province' => $province,
            ]);

        if (is_array($zoneMembers) && !empty($zoneMembers)) {

            array_walk($zoneMembers, function (ZoneProvinceMemberInterface $zoneProvinceMember) use ($zones) {

                $zones->add($zoneProvinceMember->getZone());
            });
        }

        return $zones;
    }

    /**
     * Get all zones where the city is included in
     *
     * @param ZoneInterface $zone Zone
     * @param CityInterface $city City
     *
     * @return Collection
     */
    public function getZonesFromCity(
        $zone, $city
    )
    {
        $zones = new ArrayCollection();
        $zoneMembers = $this
            ->zoneCityMemberRepository
            ->findBy([
                'zone' => $zone,
                'city' => $city,
            ]);

        if (is_array($zoneMembers) && !empty($zoneMembers)) {

            array_walk($zoneMembers, function (ZoneCityMemberInterface $zoneCityMember) use ($zones) {

                $zones->add($zoneCityMember->getZone());
            });
        }

        return $zones;
    }

    /**
     * Get all zones where the postalcode is included in
     *
     * @param ZoneInterface       $zone       Zone
     * @param PostalCodeInterface $postalCode PostalCode
     *
     * @return Collection
     */
    public function getZonesFromPostalCode(
        $zone, $postalCode
    )
    {
        $zones = new ArrayCollection();
        $zoneMembers = $this
            ->zonePostalCodeMemberRepository
            ->findBy([
                'zone'       => $zone,
                'postalCode' => $postalCode,
            ]);

        if (is_array($zoneMembers) && !empty($zoneMembers)) {

            array_walk($zoneMembers, function (ZonePostalCodeMemberInterface $zonePostalCodeMember) use ($zones) {

                $zones->add($zonePostalCodeMember->getZone());
            });
        }

        return $zones;
    }
}
