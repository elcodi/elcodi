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
use Elcodi\Component\Geo\Factory\StateFactory;

/**
 * Class StateData
 */
class StateData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var StateFactory $stateFactory
         */
        $stateFactory = $this->getFactory('state');
        $stateObjectManager = $this->getObjectManager('state');

        $stateCatalunya = $stateFactory
            ->create()
            ->setId('es-cat')
            ->setCode('cat')
            ->setName('Catalunya')
            ->setCountry($this->getReference('country-spain'))
            ->setEnabled(true);

        $stateObjectManager->persist($stateCatalunya);
        $this->addReference('state-catalunya', $stateCatalunya);

        $stateObjectManager->flush([
            $stateCatalunya,
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
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\CountryData',
        ];
    }
}
