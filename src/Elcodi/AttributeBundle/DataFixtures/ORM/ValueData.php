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

namespace Elcodi\AttributeBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ValueData
 */
class ValueData extends AbstractFixture
{
    /**
     * Loads sample fixtures for Value entities
     *
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        /**
         * @var Attribute $sizeAttribute
         * @var Attribute $colorAttribute
         */
        $sizeAttribute = $this->getReference('attribute-size');
        $colorAttribute = $this->getReference('attribute-color');

        /* Colors */

        /* Red */
        $redValue = $this->container->get('elcodi.core.attribute.factory.value')->create();
        $redValue
            ->setName('Red')
            ->setDisplayName('Red')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $objectManager->persist($redValue);
        $this->addReference('value-color-red', $redValue);

        /* White */
        $whiteValue = $this->container->get('elcodi.core.attribute.factory.value')->create();
        $whiteValue
            ->setName('White')
            ->setDisplayName('White')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $objectManager->persist($whiteValue);
        $this->addReference('value-color-white', $whiteValue);

        /* Blue */
        $blueValue = $this->container->get('elcodi.core.attribute.factory.value')->create();
        $blueValue
            ->setName('Blue')
            ->setDisplayName('Blue')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $objectManager->persist($blueValue);
        $this->addReference('value-color-blue', $blueValue);

        /* Sizes */

        /* Small */
        $smallValue = $this->container->get('elcodi.core.attribute.factory.value')->create();
        $smallValue
            ->setName('Small')
            ->setDisplayName('Small')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $objectManager->persist($smallValue);
        $this->addReference('value-size-small', $smallValue);

        /* Medium */
        $mediumValue = $this->container->get('elcodi.core.attribute.factory.value')->create();
        $mediumValue
            ->setName('Medium')
            ->setDisplayName('Medium')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $objectManager->persist($mediumValue);
        $this->addReference('value-size-medium', $mediumValue);

        /* Large */
        $largeValue = $this->container->get('elcodi.core.attribute.factory.value')->create();
        $largeValue
            ->setName('Large')
            ->setDisplayName('Large')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $objectManager->persist($largeValue);
        $this->addReference('value-size-large', $largeValue);

        $objectManager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
