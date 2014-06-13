<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\ProductBundle\Entity\Interfaces\ManufacturerInterface;

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
         * Category
         *
         * @var ManufacturerInterface $manufacturer
         */
        $manufacturer = $this->container->get('elcodi.core.product.factory.manufacturer')->create();
        $manufacturer
            ->setName('manufacturer')
            ->setSlug('manufacturer')
            ->setDescription('manufacturer description');

        $manager->persist($manufacturer);
        $this->addReference('manufacturer', $manufacturer);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
