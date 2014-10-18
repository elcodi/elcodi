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

namespace Elcodi\Bundle\TaxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Tax\Factory\TaxFactory;

/**
 * AdminData class
 *
 * Load fixtures of tax entities
 */
class TaxData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectManager $taxObjectManager
         * @var TaxFactory    $taxFactory
         */
        $taxObjectManager = $this->get('elcodi.object_manager.tax');
        $taxFactory = $this->get('elcodi.factory.tax');

        $tax21 = $taxFactory->create();
        $tax21
            ->setName('tax21')
            ->setDescription('This is my tax 21')
            ->setValue(21.0);

        $taxObjectManager->persist($tax21);
        $this->addReference('tax-21', $tax21);

        $tax16 = $taxFactory->create();
        $tax16
            ->setName('tax16')
            ->setDescription('This is my tax 16')
            ->setValue(16.0);

        $taxObjectManager->persist($tax16);
        $this->addReference('tax-16', $tax16);

        $taxObjectManager->flush();
    }
}
