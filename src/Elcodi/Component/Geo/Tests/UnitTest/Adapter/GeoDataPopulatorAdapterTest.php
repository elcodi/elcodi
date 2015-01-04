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

namespace Elcodi\Component\Geo\Tests\UnitTest\Adapter;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Geo\Entity\City;
use Elcodi\Component\Geo\Entity\Country;
use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\PostalCode;
use Elcodi\Component\Geo\Entity\Province;
use Elcodi\Component\Geo\Entity\State;

/**
 * Class GeoDataPopulatorAdapterTest
 */
class GeoDataPopulatorAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the popoulate adapter
     */
    public function testPopulateCountry()
    {
        $this->markTestSkipped("Test too large");

        $countryFactory = $this
            ->getMockBuilder('Elcodi\Component\Geo\Factory\CountryFactory')
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $countryFactory
            ->expects($this->any())
            ->method('create')
            ->will($this->returnCallback(function () {
                return new Country();
            }));

        $stateFactory = $this
            ->getMockBuilder('Elcodi\Component\Geo\Factory\StateFactory')
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $stateFactory
            ->expects($this->any())
            ->method('create')
            ->will($this->returnCallback(function () {
                return new State();
            }));

        $provinceFactory = $this
            ->getMockBuilder('Elcodi\Component\Geo\Factory\ProvinceFactory')
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $provinceFactory
            ->expects($this->any())
            ->method('create')
            ->will($this->returnCallback(function () {
                return new Province();
            }));

        $cityFactory = $this
            ->getMockBuilder('Elcodi\Component\Geo\Factory\CityFactory')
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $cityFactory
            ->expects($this->any())
            ->method('create')
            ->will($this->returnCallback(function () {
                return new City();
            }));

        $postalCodeFactory = $this
            ->getMockBuilder('Elcodi\Component\Geo\Factory\PostalCodeFactory')
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $postalCodeFactory
            ->expects($this->any())
            ->method('create')
            ->will($this->returnCallback(function () {
                return new PostalCode();
            }));

        $geoBuilder = $this
            ->getMockBuilder('Elcodi\Component\Geo\Builder\GeoBuilder')
            ->setMethods(null)
            ->setConstructorArgs([
                $countryFactory,
                $stateFactory,
                $provinceFactory,
                $cityFactory,
                $postalCodeFactory,
            ])
            ->getMock();

        $geoDataPopulatorAdapter = $this
            ->getMockBuilder('\Elcodi\Component\Geo\Adapter\Populator\GeoDataPopulatorAdapter')
            ->setMethods([
                'getDataFilePathFromCountryCode',
            ])
            ->setConstructorArgs([$geoBuilder])
            ->getMock();

        $geoDataPopulatorAdapter
            ->expects($this->any())
            ->method('getDataFilePathFromCountryCode')
            ->will($this->returnValue(dirname(__FILE__) . '/Fixtures/geodata.fr.zip'));

        $output = $this->getMock('Symfony\Component\Console\Output\OutputInterface');

        $country = $geoDataPopulatorAdapter->populateCountry($output, 'FR', true);

        $this
            ->blockTestCountry($country)
            ->blockTestStates($country)
            ->blockTestProvinces($country);
    }

    /**
     * Test the country entity
     *
     * @param CountryInterface $country Country
     *
     * @return $this Self Object
     */
    public function blockTestCountry(CountryInterface $country)
    {
        $this->assertEquals('FR', $country->getCode());

        return $this;
    }

    /**
     * Test the states entities
     *
     * @param CountryInterface $country Country
     *
     * @return $this Self Object
     */
    public function blockTestStates(CountryInterface $country)
    {
        $states = $country->getStates();
        $this->assertEquals(23, $states->count());

        return $this;
    }

    /**
     * Test the provinces entities
     *
     * @param CountryInterface $country Country
     *
     * @return $this Self Object
     */
    public function blockTestProvinces(CountryInterface $country)
    {
        $nbProvinces = 0;
        $nbCities = 0;
        $nbPostalCodes = 0;

        $country
            ->getStates()
            ->map(function (StateInterface $state) use (&$nbProvinces, &$nbCities, &$nbPostalCodes) {

                $provinces = $state->getProvinces();
                $nbProvinces += $provinces->count();
                $provinces->map(function (ProvinceInterface $province) use (&$nbCities, &$nbPostalCodes) {

                    $cities = $province->getCities();
                    $nbCities += $cities->count();
                    $cities->map(function (CityInterface $city) use (&$nbPostalCodes) {

                        $cityPostalCodes = $city->getPostalCodes();
                        $nbPostalCodes += $cityPostalCodes->count();
                    });
                });
            });

        $this->assertEquals(98, $nbProvinces);
        $this->assertEquals(36631, $nbCities);
        $this->assertEquals(20414, $nbPostalCodes);

        return $this;
    }
}
