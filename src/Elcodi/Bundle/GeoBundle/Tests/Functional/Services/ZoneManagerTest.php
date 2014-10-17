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

namespace Elcodi\Bundle\GeoBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Factory\CityFactory;
use Elcodi\Component\Geo\Factory\CountryFactory;
use Elcodi\Component\Geo\Factory\PostalCodeFactory;
use Elcodi\Component\Geo\Factory\ProvinceFactory;
use Elcodi\Component\Geo\Factory\StateFactory;
use Elcodi\Component\Geo\Factory\ZoneFactory;

/**
 * Class ZoneManagerTest
 */
class ZoneManagerTest extends WebTestCase
{
    /**
     * @var ZoneInterface
     *
     * Zone
     */
    protected $zone;

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.geo.service.zone_manager',
            'elcodi.zone_manager',
        ];
    }

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var ZoneFactory $zoneFactory
         */
        $zoneFactory = $this->getFactory('zone');
        $this->zone = $zoneFactory
            ->create()
            ->setCode('UUEE')
            ->setName('European Union');
        $this->flush($this->zone);
        $this->clear($this->zone);
    }

    /**
     * Test adding a country in a zone
     */
    public function testAddElementToZone()
    {
        /**
         * @var CountryFactory $countryFactory
         */
        $countryFactory = $this
            ->getFactory('country');

        $country = $countryFactory
            ->create()
            ->setCode('UK')
            ->setName('United Kingdom');
        $this->flush($country);

        $this
            ->get('elcodi.zone_manager')
            ->addElementToZone(
                $this->zone,
                $country
            );

        $this->clear($this->zone);
        $zone = $this->find('zone', 'UUEE');
        $this->assertCount(1, $zone->getMembers());

        $this
            ->get('elcodi.zone_manager')
            ->addElementToZone(
                $this->zone,
                $country
            );

        $this->clear($this->zone);
        $zone = $this->find('zone', 'UUEE');
        $this->assertCount(1, $zone->getMembers());

        /**
         * @var StateFactory $stateFactory
         */
        $stateFactory = $this
            ->getFactory('state');

        $state = $stateFactory
            ->create()
            ->setId('UK_ST1')
            ->setCode('ST1')
            ->setName('United Kingdom state 1')
            ->setCountry($country);

        $this->flush($state);

        $this
            ->get('elcodi.zone_manager')
            ->addElementToZone(
                $this->zone,
                $state
            );

        $this->clear($this->zone);
        $zone = $this->find('zone', 'UUEE');
        $this->assertCount(2, $zone->getMembers());

        /**
         * @var ProvinceFactory $provinceFactory
         */
        $provinceFactory = $this
            ->getFactory('province');

        $province = $provinceFactory
            ->create()
            ->setId('UK_ST1_PR1')
            ->setCode('PR1')
            ->setName('United Kingdom province 1')
            ->setState($state);

        $this->flush($province);

        $this
            ->get('elcodi.zone_manager')
            ->addElementToZone(
                $this->zone,
                $province
            );

        $this->clear($this->zone);
        $zone = $this->find('zone', 'UUEE');
        $this->assertCount(3, $zone->getMembers());

        /**
         * @var CityFactory $cityFactory
         */
        $cityFactory = $this
            ->getFactory('city');

        $city = $cityFactory
            ->create()
            ->setId('UK_ST1_PR1_london')
            ->setName('London')
            ->setProvince($province);

        $this->flush($city);

        $this
            ->get('elcodi.zone_manager')
            ->addElementToZone(
                $this->zone,
                $city
            );

        $this->clear($this->zone);
        $zone = $this->find('zone', 'UUEE');
        $this->assertCount(4, $zone->getMembers());

        /**
         * @var PostalCodeFactory $postalCodeFactory
         */
        $postalCodeFactory = $this
            ->getFactory('postal_code');

        $postalCode = $postalCodeFactory
            ->create()
            ->setId('UK_00001')
            ->setCode('00001')
            ->addCity($city);

        $this->flush($postalCode);

        $this
            ->get('elcodi.zone_manager')
            ->addElementToZone(
                $this->zone,
                $postalCode
            );

        $this->clear($this->zone);
        $zone = $this->find('zone', 'UUEE');
        $this->assertCount(5, $zone->getMembers());
    }
}
