<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Geo\Factory\LocationFactory;

/**
 * Class LocationData
 */
class LocationData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var LocationFactory $locationFactory
         */
        $locationFactory = $this->getFactory('location');
        $locationObjectManager = $this->getObjectManager('location');

        $locationSpain = $locationFactory
            ->create()
            ->setId('ES')
            ->setName('Spain')
            ->setCode('ES')
            ->setType('country');

        $locationObjectManager->persist($locationSpain);
        $this->addReference('location-spain', $locationSpain);

        $locationCatalunya = $locationFactory
            ->create()
            ->setId('ES_CA')
            ->setName('Catalunya')
            ->setCode('CA')
            ->setType('provincia')
            ->addParent($locationSpain);

        $locationObjectManager->persist($locationCatalunya);
        $this->addReference('location-catalunya', $locationCatalunya);

        $locationVallesOriental = $locationFactory
            ->create()
            ->setId('ES_CA_VO')
            ->setName('Valles Oriental')
            ->setCode('VO')
            ->setType('comarca')
            ->addParent($locationCatalunya);

        $locationObjectManager->persist($locationVallesOriental);
        $this->addReference('location-valles-oriental', $locationVallesOriental);

        $locationLaBatlloria = $locationFactory
            ->create()
            ->setId('ES_CA_VO_LaBatlloria')
            ->setName('La batlloria')
            ->setCode('LaBatlloria')
            ->setType('city')
            ->addParent($locationVallesOriental);

        $locationObjectManager->persist($locationLaBatlloria);
        $this->addReference('location-la-batlloria', $locationLaBatlloria);

        $locationSantCeloni = $locationFactory
            ->create()
            ->setId('ES_CA_VO_SantCeloni')
            ->setName('Sant Celoni')
            ->setCode('SantCeloni')
            ->setType('city')
            ->addParent($locationVallesOriental);

        $locationObjectManager->persist($locationSantCeloni);
        $this->addReference('location-sant-celoni', $locationSantCeloni);

        $locationViladecavalls = $locationFactory
            ->create()
            ->setId('ES_CA_VO_Viladecavalls')
            ->setName('Viladecavalls')
            ->setCode('Viladecavalls')
            ->setType('city')
            ->addParent($locationVallesOriental);

        $locationObjectManager->persist($locationViladecavalls);
        $this->addReference('location-viladecavalls', $locationViladecavalls);

        $location08021 = $locationFactory
            ->create()
            ->setId('ES_CA_VO_Viladecavalls_08021')
            ->setName('08021')
            ->setCode('08021')
            ->setType('postalcode')
            ->addParent($locationViladecavalls);

        $locationObjectManager->persist($location08021);
        $this->addReference('location-08021', $location08021);

        $location08470 = $locationFactory
            ->create()
            ->setId('ES_CA_VO_SantCeloni_08470')
            ->setName('08470')
            ->setCode('08470')
            ->setType('postalcode')
            ->addParent($locationLaBatlloria)
            ->addParent($locationSantCeloni);

        $locationObjectManager->persist($location08470);
        $this->addReference('location-08470', $location08470);

        $locationObjectManager->flush([
            $locationSpain,
            $locationCatalunya,
            $locationVallesOriental,
            $locationSantCeloni,
            $locationViladecavalls,
            $location08021,
        ]);
    }
}
