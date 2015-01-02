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
use Elcodi\Component\Geo\Factory\PostalCodeFactory;

/**
 * Class PostalcodeData
 */
class PostalcodeData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var PostalCodeFactory $postalCodeFactory
         */
        $postalCodeFactory = $this->getFactory('postal_code');
        $postalCodeObjectManager = $this->getObjectManager('postal_code');

        $postalcode08021 = $postalCodeFactory
            ->create()
            ->setId('es-cat-bar-bar-08021')
            ->setCode('08021')
            ->addCity($this->getReference('city-barcelona'))
            ->setEnabled(true);

        $postalCodeObjectManager->persist($postalcode08021);
        $this->addReference('postalcode-08021', $postalcode08021);

        $postalcode08232 = $postalCodeFactory
            ->create()
            ->setId('es-cat-bar-viladecavalls-08232')
            ->setCode('08232')
            ->addCity($this->getReference('city-viladecavalls'))
            ->setEnabled(true);

        $postalCodeObjectManager->persist($postalcode08232);
        $this->addReference('postalcode-08232', $postalcode08232);

        $postalCodeObjectManager->flush([
            $postalcode08021,
            $postalcode08232,
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
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\CityData',
        ];
    }
}
