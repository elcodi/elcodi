<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class LocationData.
 */
class LocationData extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $locationDirector
         */
        $locationDirector = $this->getDirector('location');

        $locationSpain = $locationDirector
            ->create()
            ->setId('ES')
            ->setName('Spain')
            ->setCode('ES')
            ->setType('country');

        $locationCatalunya = $locationDirector
            ->create()
            ->setId('ES_CA')
            ->setName('Catalunya')
            ->setCode('CA')
            ->setType('provincia')
            ->addParent($locationSpain);

        $locationVallesOriental = $locationDirector
            ->create()
            ->setId('ES_CA_VO')
            ->setName('Valles Oriental')
            ->setCode('VO')
            ->setType('comarca')
            ->addParent($locationCatalunya);

        $locationLaBatlloria = $locationDirector
            ->create()
            ->setId('ES_CA_VO_LaBatlloria')
            ->setName('La batlloria')
            ->setCode('LaBatlloria')
            ->setType('city')
            ->addParent($locationVallesOriental);

        $locationSantCeloni = $locationDirector
            ->create()
            ->setId('ES_CA_VO_SantCeloni')
            ->setName('Sant Celoni')
            ->setCode('SantCeloni')
            ->setType('city')
            ->addParent($locationVallesOriental);

        $locationViladecavalls = $locationDirector
            ->create()
            ->setId('ES_CA_VO_Viladecavalls')
            ->setName('Viladecavalls')
            ->setCode('Viladecavalls')
            ->setType('city')
            ->addParent($locationVallesOriental);

        $location08021 = $locationDirector
            ->create()
            ->setId('ES_CA_VO_Viladecavalls_08021')
            ->setName('08021')
            ->setCode('08021')
            ->setType('postalcode')
            ->addParent($locationViladecavalls);

        $location08470 = $locationDirector
            ->create()
            ->setId('ES_CA_VO_SantCeloni_08470')
            ->setName('08470')
            ->setCode('08470')
            ->setType('postalcode')
            ->addParent($locationLaBatlloria)
            ->addParent($locationSantCeloni);

        $locationDirector->save([
            $locationSpain,
            $locationCatalunya,
            $locationVallesOriental,
            $locationLaBatlloria,
            $locationSantCeloni,
            $locationViladecavalls,
            $location08021,
            $location08470,
        ]);

        $this->addReference('location-spain', $locationSpain);
        $this->addReference('location-catalunya', $locationCatalunya);
        $this->addReference('location-valles-oriental', $locationVallesOriental);
        $this->addReference('location-la-batlloria', $locationLaBatlloria);
        $this->addReference('location-sant-celoni', $locationSantCeloni);
        $this->addReference('location-viladecavalls', $locationViladecavalls);
        $this->addReference('location-08021', $location08021);
        $this->addReference('location-08470', $location08470);
    }
}
