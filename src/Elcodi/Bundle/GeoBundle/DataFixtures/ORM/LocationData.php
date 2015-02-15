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
use Elcodi\Component\Geo\Entity\Location;
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

        $locationSantCeloni = $locationFactory
            ->create()
            ->setId('ES_CA_VO_SantCeloni')
            ->setName('Sant Celoni')
            ->setCode('SantCeloni')
            ->setType('city')
            ->addParent($locationVallesOriental);

        $locationObjectManager->persist($locationSantCeloni);
        $this->addReference('location-sant-celoni', $locationSantCeloni);

        $locationObjectManager->flush([
            $locationSpain,
            $locationCatalunya,
            $locationVallesOriental,
            $locationSantCeloni,
        ]);
    }
}
