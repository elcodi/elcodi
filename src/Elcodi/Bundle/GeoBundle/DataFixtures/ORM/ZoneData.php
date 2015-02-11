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

namespace Elcodi\Bundle\GeoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Geo\Entity\ZoneCityMember;
use Elcodi\Component\Geo\Entity\ZonePostalCodeMember;
use Elcodi\Component\Geo\Factory\ZoneFactory;

/**
 * Class ZoneData
 */
class ZoneData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ZoneFactory $zoneFactory
         */
        $zoneFactory = $this->getFactory('zone');
        $zoneObjectManager = $this->getObjectManager('zone');

        /**
         * Zone Barcelona
         */
        $zoneBarcelona = $zoneFactory
            ->create()
            ->setCode('zone-barcelona')
            ->setName('Barcelona zone');

        $zoneCityMemberBarcelona = new ZoneCityMember(
            $zoneBarcelona,
            $this->getReference('city-barcelona')
        );

        $zoneBarcelona->addMember($zoneCityMemberBarcelona);

        $zoneObjectManager->persist($zoneBarcelona);
        $zoneObjectManager->persist($zoneCityMemberBarcelona);
        $this->addReference('zone-barcelona', $zoneBarcelona);

        /**
         * Zone Viladecavalls
         */
        $zoneViladecavalls = $zoneFactory
            ->create()
            ->setCode('zone-viladecavalls')
            ->setName('Viladecavalls zone');

        $zonePostalcodeMemberViladecavalls = new ZonePostalCodeMember(
            $zoneViladecavalls,
            $this->getReference('postalcode-08232')
        );

        $zoneViladecavalls->addMember($zonePostalcodeMemberViladecavalls);

        $zoneObjectManager->persist($zoneViladecavalls);
        $zoneObjectManager->persist($zonePostalcodeMemberViladecavalls);
        $this->addReference('zone-viladecavalls', $zoneViladecavalls);

        $zoneObjectManager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\AddressData',
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\PostalcodeData',
        ];
    }
}
