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

namespace Elcodi\Bundle\ConfigurationBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Configuration\Entity\Configuration;

/**
 * Class ConfigurationData
 */
class ConfigurationData extends AbstractFixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var Configuration $parameter1
         */
        $parameter1 = $this
            ->get('elcodi.factory.configuration')
            ->create();
        $parameter1
            ->setParameter('parameter1')
            ->setValue('value1')
            ->setEnabled(true);
        $manager->persist($parameter1);

        /**
         * @var Configuration $parameter2
         */
        $parameter1 = $this
            ->get('elcodi.factory.configuration')
            ->create();
        $parameter1
            ->setParameter('parameter2')
            ->setValue('value2')
            ->setEnabled(true);
        $manager->persist($parameter1);

        $manager->flush();
    }
}
