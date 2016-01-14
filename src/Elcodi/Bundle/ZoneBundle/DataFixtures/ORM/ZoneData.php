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

namespace Elcodi\Bundle\ZoneBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class ZoneData.
 */
class ZoneData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Loads sample fixtures for Zone entities.
     *
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        /**
         * @var ObjectDirector $zoneDirector
         */
        $zoneDirector = $this->getDirector('zone');

        $zone08021 = $zoneDirector
            ->create()
            ->setName('Postalcode 08021')
            ->setCode('zone-08021')
            ->addLocation($this->getReference('location-sant-celoni'))
            ->addLocation($this->getReference('location-08021'));

        $this->setReference('zone-08021', $zone08021);
        $zoneDirector->save($zone08021);

        $zoneViladecavalls = $zoneDirector
            ->create()
            ->setName('Viladecavalls i alrededores')
            ->setCode('zone-viladecavalls')
            ->addLocation($this->getReference('location-viladecavalls'));

        $this->setReference('zone-viladecavalls', $zoneViladecavalls);
        $zoneDirector->save($zoneViladecavalls);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\LocationData',
        ];
    }
}
