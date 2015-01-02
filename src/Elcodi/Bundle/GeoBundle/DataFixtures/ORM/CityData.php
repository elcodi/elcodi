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

namespace Elcodi\Bundle\GeoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Geo\Factory\CityFactory;

/**
 * Class CityData
 */
class CityData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CityFactory $cityFactory
         */
        $cityFactory = $this->getFactory('city');
        $cityObjectManager = $this->getObjectManager('city');

        $cityBarcelona = $cityFactory
            ->create()
            ->setId('es-cat-bar-bar')
            ->setName('Barcelona')
            ->setProvince($this->getReference('province-barcelones'))
            ->setEnabled(true);

        $cityObjectManager->persist($cityBarcelona);
        $this->addReference('city-barcelona', $cityBarcelona);

        $cityViladecavalls = $cityFactory
            ->create()
            ->setId('es-cat-bar-viladecavalls')
            ->setName('Viladecavalls')
            ->setProvince($this->getReference('province-barcelones'))
            ->setEnabled(true);

        $cityObjectManager->persist($cityViladecavalls);
        $this->addReference('city-viladecavalls', $cityViladecavalls);

        $cityObjectManager->flush([
            $cityBarcelona,
            $cityViladecavalls,
        ]);
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
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\ProvinceData',
        ];
    }
}
