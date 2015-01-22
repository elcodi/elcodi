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

namespace Elcodi\Bundle\AttributeBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Attribute\Factory\AttributeFactory;
use Elcodi\Component\Attribute\Factory\ValueFactory;

/**
 * Class AttributeData
 */
class AttributeData extends AbstractFixture
{
    /**
     * Loads sample fixtures for Attribute entities
     *
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        /**
         * @var ValueFactory     $attributeValueFactory
         * @var AttributeFactory $attributeFactory
         * @var ObjectManager    $attributeValueObjectManager
         * @var ObjectManager    $attributeObjectManager
         */
        $attributeValueFactory = $this->getFactory('attribute_value');
        $attributeFactory = $this->getFactory('attribute');
        $attributeValueObjectManager = $this->getObjectManager('attribute_value');
        $attributeObjectManager = $this->getObjectManager('attribute');

        /**
         * Sizes
         */

        $sizeAttribute = $attributeFactory
            ->create()
            ->setName('Size')
            ->setEnabled(true);

        $attributeObjectManager->persist($sizeAttribute);
        $this->addReference('attribute-size', $sizeAttribute);

        $smallValue = $attributeValueFactory
            ->create()
            ->setValue('Small')
            ->setAttribute($sizeAttribute);

        $attributeValueObjectManager->persist($smallValue);
        $this->addReference('value-size-small', $smallValue);

        $mediumValue = $attributeValueFactory
            ->create()
            ->setValue('Medium')
            ->setAttribute($sizeAttribute);

        $attributeValueObjectManager->persist($mediumValue);
        $this->addReference('value-size-medium', $mediumValue);

        $largeValue = $attributeValueFactory
            ->create()
            ->setValue('Large')
            ->setAttribute($sizeAttribute);

        $attributeValueObjectManager->persist($largeValue);
        $this->addReference('value-size-large', $largeValue);

        /**
         * Colors
         */

        $colorAttribute = $attributeFactory
            ->create()
            ->setName('Color')
            ->setEnabled(true);

        $attributeObjectManager->persist($colorAttribute);
        $this->addReference('attribute-color', $colorAttribute);

        $blueValue = $attributeValueFactory
            ->create()
            ->setValue('Blue')
            ->setAttribute($colorAttribute);

        $attributeValueObjectManager->persist($blueValue);
        $this->addReference('value-color-blue', $blueValue);

        $whiteValue = $attributeValueFactory
            ->create()
            ->setValue('White')
            ->setAttribute($colorAttribute);

        $attributeValueObjectManager->persist($whiteValue);
        $this->addReference('value-color-white', $whiteValue);

        $redValue = $attributeValueFactory
            ->create()
            ->setValue('Red')
            ->setAttribute($colorAttribute);

        $attributeValueObjectManager->persist($redValue);
        $this->addReference('value-color-red', $redValue);


        $attributeObjectManager->flush();
        $attributeValueObjectManager->flush();
    }
}
