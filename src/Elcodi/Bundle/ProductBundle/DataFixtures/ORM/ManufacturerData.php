<?php

/**
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
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;

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
}
