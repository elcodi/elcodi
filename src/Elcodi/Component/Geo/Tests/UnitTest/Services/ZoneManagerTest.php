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

use Doctrine\Common\Persistence\ObjectManager;
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
use Elcodi\Component\Geo\Services\ZoneManager;
use Elcodi\Component\Geo\Services\ZoneMatcher;

/**
 * Class ZoneManagerTest
 */
class ZoneManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     *
     * Object manager
     */
    protected $objectManager;

    /**
     * @var ZoneManager
     *
     * Zone manager
     */
    protected $zoneManager;

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
        $this->objectManager = $this
            ->getMock('Doctrine\Common\Persistence\ObjectManager');

        $this->zoneMatcher = $this
            ->getMock('Elcodi\Component\Geo\Services\ZoneMatcher');

        $this->zoneManager = new ZoneManager(
            $this->objectManager,
            $this->zoneMatcher,
            'Elcodi\Component\Geo\Entity\ZoneCountryMember',
            'Elcodi\Component\Geo\Entity\ZoneStateMember',
            'Elcodi\Component\Geo\Entity\ZoneProvinceMember',
            'Elcodi\Component\Geo\Entity\ZoneCityMember',
            'Elcodi\Component\Geo\Entity\ZonePostalCodeMember'
        );
    }

    /**
     * Test add country in zone
     *
     * @dataProvider dataAddAnyInZone
     */
    public function testAddCountryInZone($exists, $persist, $flush)
    {
        $this
            ->objectManager
            ->expects($persist)
            ->method('persist')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZoneCountryMemberInterface'));

        $this
            ->objectManager
            ->expects($flush)
            ->method('flush')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZoneCountryMemberInterface'));

        $this
            ->zoneMatcher
            ->expects($this->any())
            ->method('isCountryContainedInZone')
            ->will($this->returnValue($exists));

        $country = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CountryInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $this
            ->zoneManager
            ->addCountryToZone($zone, $country);
    }

    /**
     * Test add state in zone
     *
     * @dataProvider dataAddAnyInZone
     */
    public function testAddStateInZone($exists, $persist, $flush)
    {
        $this
            ->objectManager
            ->expects($persist)
            ->method('persist')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZoneStateMemberInterface'));

        $this
            ->objectManager
            ->expects($flush)
            ->method('flush')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZoneStateMemberInterface'));

        $this
            ->zoneMatcher
            ->expects($this->any())
            ->method('isStateContainedInZone')
            ->will($this->returnValue($exists));

        $state = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\StateInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $this
            ->zoneManager
            ->addStateToZone($zone, $state);
    }

    /**
     * Test add province in zone
     *
     * @dataProvider dataAddAnyInZone
     */
    public function testAddProvinceInZone($exists, $persist, $flush)
    {
        $this
            ->objectManager
            ->expects($persist)
            ->method('persist')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZoneProvinceMemberInterface'));

        $this
            ->objectManager
            ->expects($flush)
            ->method('flush')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZoneProvinceMemberInterface'));

        $this
            ->zoneMatcher
            ->expects($this->any())
            ->method('isProvinceContainedInZone')
            ->will($this->returnValue($exists));

        $province = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $this
            ->zoneManager
            ->addProvinceToZone($zone, $province);
    }

    /**
     * Test add city in zone
     *
     * @dataProvider dataAddAnyInZone
     */
    public function testAddCityInZone($exists, $persist, $flush)
    {
        $this
            ->objectManager
            ->expects($persist)
            ->method('persist')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface'));

        $this
            ->objectManager
            ->expects($flush)
            ->method('flush')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface'));

        $this
            ->zoneMatcher
            ->expects($this->any())
            ->method('isCityContainedInZone')
            ->will($this->returnValue($exists));

        $city = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\CityInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $this
            ->zoneManager
            ->addCityToZone($zone, $city);
    }

    /**
     * Test add postalCode in zone
     *
     * @dataProvider dataAddAnyInZone
     */
    public function testAddPostalCodeInZone($exists, $persist, $flush)
    {
        $this
            ->objectManager
            ->expects($persist)
            ->method('persist')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZonePostalCodeMemberInterface'));

        $this
            ->objectManager
            ->expects($flush)
            ->method('flush')
            ->with($this->isInstanceOf('Elcodi\Component\Geo\Entity\Interfaces\ZonePostalCodeMemberInterface'));

        $this
            ->zoneMatcher
            ->expects($this->any())
            ->method('isPostalCodeContainedInZone')
            ->will($this->returnValue($exists));

        $postalCode = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface');

        $zone = $this
            ->getMock('Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface');

        $this
            ->zoneManager
            ->addPostalCodeToZone($zone, $postalCode);
    }

    /**
     * Data for test testAddCountryInZone
     */
    public function dataAddAnyInZone()
    {
        return [
            [false, $this->once(), $this->once()],
            [true, $this->never(), $this->never()],
        ];
    }
}
