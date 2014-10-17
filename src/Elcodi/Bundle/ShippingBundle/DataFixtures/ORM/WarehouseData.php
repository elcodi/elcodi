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

namespace Elcodi\Bundle\ShippingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Shipping\Factory\WarehouseFactory;

/**
 * Class WarehouseData
 */
class WarehouseData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var WarehouseFactory $warehouseFactory
         */
        $warehouseFactory = $this->container->get('elcodi.factory.warehouse');
        $warehouse = $warehouseFactory->create();
        $warehouse
            ->setName('warehouse')
            ->setDescription('Testing warehouse')
            ->setAddress($this->getReference('address-viladecavalls'))
            ->setEnabled(true);

        $manager->persist($warehouse);
        $this->addReference('warehouse', $warehouse);

        $manager->flush();
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
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\AddressData',
        ];
    }
}
