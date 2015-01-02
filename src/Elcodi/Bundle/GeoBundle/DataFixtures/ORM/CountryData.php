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

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Geo\Factory\CountryFactory;

/**
 * Class CountryData
 */
class CountryData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CountryFactory $countryFactory
         */
        $countryFactory = $this->getFactory('country');
        $countryObjectManager = $this->getObjectManager('country');

        $countrySpain = $countryFactory
            ->create()
            ->setCode('es')
            ->setName('Spain')
            ->setEnabled(true);

        $countryObjectManager->persist($countrySpain);
        $this->addReference('country-spain', $countrySpain);

        $countryObjectManager->flush([
            $countrySpain
        ]);
    }
}
