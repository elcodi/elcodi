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
use Elcodi\Component\Configuration\Factory\ConfigurationFactory;

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
         * @var ConfigurationFactory $configurationFactory
         */
        $configurationFactory = $this->getFactory('configuration');
        $configurationObjectManager = $this->getObjectManager('configuration');

        /**
         * Parameter1
         */
        $parameter1 = $configurationFactory
            ->create()
            ->setParameter('parameter1')
            ->setValue('value1')
            ->setEnabled(true);

        $configurationObjectManager->persist($parameter1);

        /**
         * Parameter2
         */
        $parameter2 = $configurationFactory
            ->create()
            ->setParameter('parameter2')
            ->setValue('value2')
            ->setEnabled(true);

        $configurationObjectManager->persist($parameter2);

        $configurationObjectManager->flush([
            $parameter1,
            $parameter2,
        ]);
    }
}
