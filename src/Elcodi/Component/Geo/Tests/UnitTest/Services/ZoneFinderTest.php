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

namespace Elcodi\Component\Geo\Tests\UnitTest\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Geo\Services\ZoneFinder;

/**
 * Class ZoneFinderTest
 */
class ZoneFinderTest extends PHPUnit_Framework_TestCase
{
    /**
     * test get zones from address
     */
    public function testGetZonesFromAddress()
    {
        $zone = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');
        $city = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\CityInterface');
        $address = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface');
        $zoneCityMember = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface');

        $address
            ->expects($this->any())
            ->method('getCity')
            ->will($this->returnValue($city));

        $zoneCityMember
            ->expects($this->any())
            ->method('getZone')
            ->will($this->returnValue($zone));

        $zoneCityMember
            ->expects($this->any())
            ->method('getCity')
            ->will($this->returnValue($city));

        $zoneCityMemberRepository = $this->getMock('Elcodi\Component\Geo\Repository\ZoneCityMemberRepository', [], [], '', false);

        $zoneCityMemberRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue([
                $zoneCityMember
            ]));

        $zoneFinder = new ZoneFinder(
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCountryMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneStateMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneProvinceMemberRepository', [], [], '', false),
            $zoneCityMemberRepository,
            $this->getMock('Elcodi\Component\Geo\Repository\ZonePostalCodeMemberRepository', [], [], '', false)
        );

        $this->assertCount(1, $zoneFinder->getZonesFromAddress($zone, $address));
    }

    /**
     * test get zones from country
     */
    public function testGetZonesFromCountry()
    {
        $zone = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');
        $country = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\CountryInterface');
        $zoneCountryMember = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneCountryMemberInterface');

        $zoneCountryMember
            ->expects($this->any())
            ->method('getZone')
            ->will($this->returnValue($zone));

        $zoneCountryMember
            ->expects($this->any())
            ->method('getCountry')
            ->will($this->returnValue($country));

        $zoneCountryMemberRepository = $this->getMock('Elcodi\Component\Geo\Repository\ZoneCountryMemberRepository', [], [], '', false);

        $zoneCountryMemberRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue([
                $zoneCountryMember
            ]));

        $zoneFinder = new ZoneFinder(
            $zoneCountryMemberRepository,
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneStateMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneProvinceMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCityMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZonePostalCodeMemberRepository', [], [], '', false)
        );

        $this->assertCount(1, $zoneFinder->getZonesFromCountry($zone, $country));
    }

    /**
     * test get zones from state
     */
    public function testGetZonesFromState()
    {
        $zone = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');
        $state = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\StateInterface');
        $zoneStateMember = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneStateMemberInterface');

        $zoneStateMember
            ->expects($this->any())
            ->method('getZone')
            ->will($this->returnValue($zone));

        $zoneStateMember
            ->expects($this->any())
            ->method('getState')
            ->will($this->returnValue($state));

        $zoneStateMemberRepository = $this->getMock('Elcodi\Component\Geo\Repository\ZoneStateMemberRepository', [], [], '', false);

        $zoneStateMemberRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue([
                $zoneStateMember
            ]));

        $zoneFinder = new ZoneFinder(
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCountryMemberRepository', [], [], '', false),
            $zoneStateMemberRepository,
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneProvinceMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCityMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZonePostalCodeMemberRepository', [], [], '', false)
        );

        $this->assertCount(1, $zoneFinder->getZonesFromState($zone, $state));
    }

    /**
     * test get zones from province
     */
    public function testGetZonesFromProvince()
    {
        $zone = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');
        $province = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface');
        $zoneProvinceMember = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneProvinceMemberInterface');

        $zoneProvinceMember
            ->expects($this->any())
            ->method('getZone')
            ->will($this->returnValue($zone));

        $zoneProvinceMember
            ->expects($this->any())
            ->method('getProvince')
            ->will($this->returnValue($province));

        $zoneProvinceMemberRepository = $this->getMock('Elcodi\Component\Geo\Repository\ZoneProvinceMemberRepository', [], [], '', false);

        $zoneProvinceMemberRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue([
                $zoneProvinceMember
            ]));

        $zoneFinder = new ZoneFinder(
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCountryMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneStateMemberRepository', [], [], '', false),
            $zoneProvinceMemberRepository,
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCityMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZonePostalCodeMemberRepository', [], [], '', false)
        );

        $this->assertCount(1, $zoneFinder->getZonesFromProvince($zone, $province));
    }

    /**
     * test get zones from city
     */
    public function testGetZonesFromCity()
    {
        $zone = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');
        $city = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\CityInterface');
        $zoneCityMember = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface');

        $zoneCityMember
            ->expects($this->any())
            ->method('getZone')
            ->will($this->returnValue($zone));

        $zoneCityMember
            ->expects($this->any())
            ->method('getCity')
            ->will($this->returnValue($city));

        $zoneCityMemberRepository = $this->getMock('Elcodi\Component\Geo\Repository\ZoneCityMemberRepository', [], [], '', false);

        $zoneCityMemberRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue([
                $zoneCityMember
            ]));

        $zoneFinder = new ZoneFinder(
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCountryMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneStateMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneProvinceMemberRepository', [], [], '', false),
            $zoneCityMemberRepository,
            $this->getMock('Elcodi\Component\Geo\Repository\ZonePostalCodeMemberRepository', [], [], '', false)
        );

        $this->assertCount(1, $zoneFinder->getZonesFromCity($zone, $city));
    }

    /**
     * test get zones from postalCode
     */
    public function testGetZonesFromPostalCode()
    {
        $zone = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');
        $postalCode = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface');
        $zonePostalCodeMember = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZonePostalCodeMemberInterface');

        $zonePostalCodeMember
            ->expects($this->any())
            ->method('getZone')
            ->will($this->returnValue($zone));

        $zonePostalCodeMember
            ->expects($this->any())
            ->method('getPostalCode')
            ->will($this->returnValue($postalCode));

        $zonePostalCodeMemberRepository = $this->getMock('Elcodi\Component\Geo\Repository\ZonePostalCodeMemberRepository', [], [], '', false);

        $zonePostalCodeMemberRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue([
                $zonePostalCodeMember
            ]));

        $zoneFinder = new ZoneFinder(
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCountryMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneStateMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneProvinceMemberRepository', [], [], '', false),
            $this->getMock('Elcodi\Component\Geo\Repository\ZoneCityMemberRepository', [], [], '', false),
            $zonePostalCodeMemberRepository
        );

        $this->assertCount(1, $zoneFinder->getZonesFromPostalCode($zone, $postalCode));
    }
}
