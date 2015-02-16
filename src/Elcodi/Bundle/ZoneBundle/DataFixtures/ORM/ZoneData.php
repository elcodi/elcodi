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

namespace Elcodi\Bundle\ZoneBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Zone\Factory\ValueFactory;
use Elcodi\Component\Zone\Factory\ZoneFactory;

/**
 * Class ZoneData
 */
class ZoneData extends AbstractFixture
{
    /**
     * Loads sample fixtures for Zone entities
     *
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        /**
         * @var ValueFactory     $ZoneValueFactory
         * @var ZoneFactory $ZoneFactory
         * @var ObjectManager    $ZoneValueObjectManager
         * @var ObjectManager    $ZoneObjectManager
         */
        $ZoneValueFactory = $this->getFactory('Zone_value');
        $ZoneFactory = $this->getFactory('Zone');
        $ZoneValueObjectManager = $this->getObjectManager('Zone_value');
        $ZoneObjectManager = $this->getObjectManager('Zone');

        /**
         * Sizes
         */
        $sizeZone = $ZoneFactory
            ->create()
            ->setName('Size')
            ->setEnabled(true);

        $ZoneObjectManager->persist($sizeZone);
        $this->addReference('Zone-size', $sizeZone);

        $smallValue = $ZoneValueFactory
            ->create()
            ->setValue('Small')
            ->setZone($sizeZone);

        $ZoneValueObjectManager->persist($smallValue);
        $this->addReference('value-size-small', $smallValue);

        $mediumValue = $ZoneValueFactory
            ->create()
            ->setValue('Medium')
            ->setZone($sizeZone);

        $ZoneValueObjectManager->persist($mediumValue);
        $this->addReference('value-size-medium', $mediumValue);

        $largeValue = $ZoneValueFactory
            ->create()
            ->setValue('Large')
            ->setZone($sizeZone);

        $ZoneValueObjectManager->persist($largeValue);
        $this->addReference('value-size-large', $largeValue);

        /**
         * Colors
         */
        $colorZone = $ZoneFactory
            ->create()
            ->setName('Color')
            ->setEnabled(true);

        $ZoneObjectManager->persist($colorZone);
        $this->addReference('Zone-color', $colorZone);

        $blueValue = $ZoneValueFactory
            ->create()
            ->setValue('Blue')
            ->setZone($colorZone);

        $ZoneValueObjectManager->persist($blueValue);
        $this->addReference('value-color-blue', $blueValue);

        $whiteValue = $ZoneValueFactory
            ->create()
            ->setValue('White')
            ->setZone($colorZone);

        $ZoneValueObjectManager->persist($whiteValue);
        $this->addReference('value-color-white', $whiteValue);

        $redValue = $ZoneValueFactory
            ->create()
            ->setValue('Red')
            ->setZone($colorZone);

        $ZoneValueObjectManager->persist($redValue);
        $this->addReference('value-color-red', $redValue);

        $ZoneObjectManager->flush();
        $ZoneValueObjectManager->flush();
    }
}
