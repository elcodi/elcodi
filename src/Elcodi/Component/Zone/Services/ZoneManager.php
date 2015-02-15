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

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberAssignableInterface;

/**
 * Class ZoneManager
 */
class ZoneManager
{
    /**
     * @var ObjectManager
     *
     * ZoneMember object manager
     */
    protected $zoneMemberObjectManager;

    /**
     * @var ZoneMatcher
     *
     * Zone matcher
     */
    protected $zoneMatcher;

    /**
     * @var string
     *
     * ZoneCountryMember namespace
     */
    protected $zoneCountryMemberNamespace;

    /**
     * @var string
     *
     * ZoneStateMember namespace
     */
    protected $zoneStateMemberNamespace;

    /**
     * @var string
     *
     * ZoneProvinceMember namespace
     */
    protected $zoneProvinceMemberNamespace;

    /**
     * @var string
     *
     * ZoneCityMember namespace
     */
    protected $zoneCityMemberNamespace;

    /**
     * @var string
     *
     * ZonePostalCodeMember namespace
     */
    protected $zonePostalCodeMemberNamespace;

    /**
     * Construct method
     *
     * @param ObjectManager $zoneMemberObjectManager       ZoneMember object manager
     * @param ZoneMatcher   $zoneMatcher                   Zone Matcher
     * @param string        $zoneCountryMemberNamespace    ZoneCountryMember namespace
     * @param string        $zoneStateMemberNamespace      ZoneStateMember namespace
     * @param string        $zoneProvinceMemberNamespace   ZoneProvinceMember namespace
     * @param string        $zoneCityMemberNamespace       ZoneCityMember namespace
     * @param string        $zonePostalCodeMemberNamespace ZonePostalCodeMember namespace
     */
    public function __construct(
        ObjectManager $zoneMemberObjectManager,
        ZoneMatcher $zoneMatcher,
        $zoneCountryMemberNamespace,
        $zoneStateMemberNamespace,
        $zoneProvinceMemberNamespace,
        $zoneCityMemberNamespace,
        $zonePostalCodeMemberNamespace
    ) {
        $this->zoneMemberObjectManager = $zoneMemberObjectManager;
        $this->zoneMatcher = $zoneMatcher;
        $this->zoneCountryMemberNamespace = $zoneCountryMemberNamespace;
        $this->zoneStateMemberNamespace = $zoneStateMemberNamespace;
        $this->zoneProvinceMemberNamespace = $zoneProvinceMemberNamespace;
        $this->zoneCityMemberNamespace = $zoneCityMemberNamespace;
        $this->zonePostalCodeMemberNamespace = $zonePostalCodeMemberNamespace;
    }

    /**
     * Add a member in a Zone
     *
     * @param ZoneInterface                 $zone   Zone
     * @param ZoneMemberAssignableInterface $entity Zone assignable entity
     *
     * @return $this Self object
     */
    public function addElementToZone(
        ZoneInterface $zone,
        ZoneMemberAssignableInterface $entity
    ) {
        if ($entity instanceof CountryInterface) {
            return $this->addCountryToZone(
                $zone,
                $entity
            );
        }

        if ($entity instanceof StateInterface) {
            return $this->addStateToZone(
                $zone,
                $entity
            );
        }

        if ($entity instanceof ProvinceInterface) {
            return $this->addProvinceToZone(
                $zone,
                $entity
            );
        }

        if ($entity instanceof CityInterface) {
            return $this->addCityToZone(
                $zone,
                $entity
            );
        }

        if ($entity instanceof PostalCodeInterface) {
            return $this->addPostalCodeToZone(
                $zone,
                $entity
            );
        }

        return $this;
    }

    /**
     * Add a Country to a Zone
     *
     * @param ZoneInterface    $zone    Zone
     * @param CountryInterface $country Country
     *
     * @return $this Self object
     */
    public function addCountryToZone(
        ZoneInterface $zone,
        CountryInterface $country
    ) {
        $zoneHasCountry = $this
            ->zoneMatcher
            ->isCountryContainedInZone(
                $zone,
                $country
            );

        if (!$zoneHasCountry) {
            $zoneCountryMember = new $this->zoneCountryMemberNamespace(
                $zone,
                $country
            );
            $zone->addMember($zoneCountryMember);

            $this->zoneMemberObjectManager->persist($zoneCountryMember);
            $this->zoneMemberObjectManager->flush($zoneCountryMember);
        }

        return $this;
    }

    /**
     * Add a State in to Zone
     *
     * @param ZoneInterface  $zone  Zone
     * @param StateInterface $state State
     *
     * @return $this Self object
     */
    public function addStateToZone(
        ZoneInterface $zone,
        StateInterface $state
    ) {
        $zoneHasState = $this
            ->zoneMatcher
            ->isStateContainedInZone(
                $zone,
                $state
            );

        if (!$zoneHasState) {
            $zoneStateMember = new $this->zoneStateMemberNamespace(
                $zone,
                $state
            );
            $zone->addMember($zoneStateMember);

            $this->zoneMemberObjectManager->persist($zoneStateMember);
            $this->zoneMemberObjectManager->flush($zoneStateMember);
        }

        return $this;
    }

    /**
     * Add a Province to a Zone
     *
     * @param ZoneInterface     $zone     Zone
     * @param ProvinceInterface $province Province
     *
     * @return $this Self object
     */
    public function addProvinceToZone(
        ZoneInterface $zone,
        ProvinceInterface $province
    ) {
        $zoneHasProvince = $this
            ->zoneMatcher
            ->isProvinceContainedInZone(
                $zone,
                $province
            );

        if (!$zoneHasProvince) {
            $zoneProvinceMember = new $this->zoneProvinceMemberNamespace(
                $zone,
                $province
            );
            $zone->addMember($zoneProvinceMember);

            $this->zoneMemberObjectManager->persist($zoneProvinceMember);
            $this->zoneMemberObjectManager->flush($zoneProvinceMember);
        }

        return $this;
    }

    /**
     * Add a City to a Zone
     *
     * @param ZoneInterface $zone Zone
     * @param CityInterface $city City
     *
     * @return $this Self object
     */
    public function addCityToZone(
        ZoneInterface $zone,
        CityInterface $city
    ) {
        $zoneHasCity = $this
            ->zoneMatcher
            ->isCityContainedInZone(
                $zone,
                $city
            );

        if (!$zoneHasCity) {
            $zoneCityMember = new $this->zoneCityMemberNamespace(
                $zone,
                $city
            );
            $zone->addMember($zoneCityMember);

            $this->zoneMemberObjectManager->persist($zoneCityMember);
            $this->zoneMemberObjectManager->flush($zoneCityMember);
        }

        return $this;
    }

    /**
     * Add a Postalcode to a Zone
     *
     * @param ZoneInterface       $zone       Zone
     * @param PostalCodeInterface $postalCode PostalCode
     *
     * @return $this Self object
     */
    public function addPostalcodeToZone(
        ZoneInterface $zone,
        PostalcodeInterface $postalCode
    ) {
        $zoneHasPostalcode = $this
            ->zoneMatcher
            ->isPostalCodeContainedInZone(
                $zone,
                $postalCode
            );

        if (!$zoneHasPostalcode) {
            $zonePostalcodeMember = new $this->zonePostalCodeMemberNamespace(
                $zone,
                $postalCode
            );
            $zone->addMember($zonePostalcodeMember);

            $this->zoneMemberObjectManager->persist($zonePostalcodeMember);
            $this->zoneMemberObjectManager->flush($zonePostalcodeMember);
        }

        return $this;
    }
}
