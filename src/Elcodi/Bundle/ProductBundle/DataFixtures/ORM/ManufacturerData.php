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

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Product\Factory\ManufacturerFactory;

/**
 * Class ManufacturerData
 */
class ManufacturerData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ManufacturerFactory $manufacturerFactory
         */
        $manufacturerObjectManager = $this->getObjectManager('manufacturer');
        $manufacturerFactory = $this->getFactory('manufacturer');

        $manufacturer = $manufacturerFactory
            ->create()
            ->setName('manufacturer')
            ->setSlug('manufacturer')
            ->setDescription('manufacturer description');

        $manufacturerObjectManager->persist($manufacturer);
        $this->addReference('manufacturer', $manufacturer);

        $manufacturerObjectManager->flush();
    }
}
