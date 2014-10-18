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

namespace Elcodi\Component\Geo\Tests\UnitTest\Services;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\ZoneCityMember;
use Elcodi\Component\Geo\Entity\ZoneCountryMember;
use Elcodi\Component\Geo\Entity\ZonePostalCodeMember;
use Elcodi\Component\Geo\Entity\ZoneProvinceMember;
use Elcodi\Component\Geo\Entity\ZoneStateMember;
use Elcodi\Component\Geo\Services\ZoneMatcher;

/**
 * Class ZoneMatcherTest
 */
class ZoneMatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ZoneMatcher
     *
     * Zone matcher
     */
    protected $zoneMatcher;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->zoneMatcher = new ZoneMatcher();
    }

    /**
     * Test add non-existing-yet country
     */
    public function testAddCountryInZoneNonExistingCountry()
    {
        $country = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CountryInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection()));

        $isCountryContainedInZone = $this
            ->zoneMatcher
            ->isCountryContainedInZone($zone, $country);

        $this->assertFalse($isCountryContainedInZone);
    }

    /**
     * Test add existing-already country
     */
    public function testAddCountryInZoneExistingCountry()
    {
        $existingCountry = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CountryInterface');

        $anotherExistingCountry = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CountryInterface');

        $country = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CountryInterface');

        $country
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnCallback(function (CountryInterface $country) use ($existingCountry) {
                return ($country === $existingCountry);
            }));

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection([
                new ZoneCountryMember($zone, $existingCountry),
                new ZoneCountryMember($zone, $anotherExistingCountry),
            ])));

        $isCountryContainedInZone = $this
            ->zoneMatcher
            ->isCountryContainedInZone($zone, $country);

        $this->assertTrue($isCountryContainedInZone);
    }

    /**
     * Test add non-existing-yet state
     */
    public function testAddStateInZoneNonExistingState()
    {
        $state = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\StateInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection()));

        $isStateContainedInZone = $this
            ->zoneMatcher
            ->isStateContainedInZone($zone, $state);

        $this->assertFalse($isStateContainedInZone);
    }

    /**
     * Test add existing-already state
     */
    public function testAddStateInZoneExistingState()
    {
        $existingState = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\StateInterface');

        $anotherExistingState = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\StateInterface');

        $state = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\StateInterface');

        $state
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnCallback(function (StateInterface $state) use ($existingState) {
                return ($state === $existingState);
            }));

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection([
                new ZoneStateMember($zone, $existingState),
                new ZoneStateMember($zone, $anotherExistingState),
            ])));

        $isStateContainedInZone = $this
            ->zoneMatcher
            ->isStateContainedInZone($zone, $state);

        $this->assertTrue($isStateContainedInZone);
    }

    /**
     * Test add non-existing-yet province
     */
    public function testAddProvinceInZoneNonExistingProvince()
    {
        $province = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection()));

        $isProvinceContainedInZone = $this
            ->zoneMatcher
            ->isProvinceContainedInZone($zone, $province);

        $this->assertFalse($isProvinceContainedInZone);
    }

    /**
     * Test add existing-already province
     */
    public function testAddProvinceInZoneExistingProvince()
    {
        $existingProvince = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface');

        $anotherExistingProvince = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface');

        $province = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface');

        $province
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnCallback(function (ProvinceInterface $province) use ($existingProvince) {
                return ($province === $existingProvince);
            }));

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection([
                new ZoneProvinceMember($zone, $existingProvince),
                new ZoneProvinceMember($zone, $anotherExistingProvince),
            ])));

        $isProvinceContainedInZone = $this
            ->zoneMatcher
            ->isProvinceContainedInZone($zone, $province);

        $this->assertTrue($isProvinceContainedInZone);
    }

    /**
     * Test add non-existing-yet city
     */
    public function testAddCityInZoneNonExistingCity()
    {
        $city = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CityInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection()));

        $isCityContainedInZone = $this
            ->zoneMatcher
            ->isCityContainedInZone($zone, $city);

        $this->assertFalse($isCityContainedInZone);
    }

    /**
     * Test add existing-already city
     */
    public function testAddCityInZoneExistingCity()
    {
        $existingCity = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CityInterface');

        $anotherExistingCity = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CityInterface');

        $city = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CityInterface');

        $city
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnCallback(function (CityInterface $city) use ($existingCity) {
                return ($city === $existingCity);
            }));

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection([
                new ZoneCityMember($zone, $existingCity),
                new ZoneCityMember($zone, $anotherExistingCity),
            ])));

        $isCityContainedInZone = $this
            ->zoneMatcher
            ->isCityContainedInZone($zone, $city);

        $this->assertTrue($isCityContainedInZone);
    }

    /**
     * Test add non-existing-yet postalCode
     */
    public function testAddPostalCodeInZoneNonExistingPostalCode()
    {
        $postalCode = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection()));

        $isPostalCodeContainedInZone = $this
            ->zoneMatcher
            ->isPostalCodeContainedInZone($zone, $postalCode);

        $this->assertFalse($isPostalCodeContainedInZone);
    }

    /**
     * Test add existing-already postalCode
     */
    public function testAddPostalCodeInZoneExistingPostalCode()
    {
        $existingPostalCode = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface');

        $anotherExistingPostalCode = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface');

        $postalCode = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface');

        $postalCode
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnCallback(function (PostalCodeInterface $postalCode) use ($existingPostalCode) {
                return ($postalCode === $existingPostalCode);
            }));

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $zone
            ->expects($this->any())
            ->method('getMembers')
            ->will($this->returnValue(new ArrayCollection([
                new ZonePostalCodeMember($zone, $existingPostalCode),
                new ZonePostalCodeMember($zone, $anotherExistingPostalCode),
            ])));

        $isPostalCodeContainedInZone = $this
            ->zoneMatcher
            ->isPostalCodeContainedInZone($zone, $postalCode);

        $this->assertTrue($isPostalCodeContainedInZone);
    }
}
