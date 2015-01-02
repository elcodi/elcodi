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

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Attribute\Entity\Attribute;
use Elcodi\Component\Attribute\Factory\ValueFactory;

/**
 * Class ValueData
 */
class ValueData extends AbstractFixture implements DependentFixtureInterface
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
         * @var ValueFactory $attributeFactory
         */
        $attributeValueFactory = $this->getFactory('attribute_value');
        $attributeValueObjectManager = $this->getObjectManager('attribute_value');
        $sizeAttribute = $this->getReference('attribute-size');
        $colorAttribute = $this->getReference('attribute-color');

        /**
         * Red
         */
        $redValue = $attributeValueFactory
            ->create()
            ->setName('Red')
            ->setDisplayName('Red')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $attributeValueObjectManager->persist($redValue);
        $this->addReference('value-color-red', $redValue);

        /**
         * White
         */
        $whiteValue = $attributeValueFactory
            ->create()
            ->setName('White')
            ->setDisplayName('White')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $attributeValueObjectManager->persist($whiteValue);
        $this->addReference('value-color-white', $whiteValue);

        /**
         * Blue
         */
        $blueValue = $attributeValueFactory
            ->create()
            ->setName('Blue')
            ->setDisplayName('Blue')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $attributeValueObjectManager->persist($blueValue);
        $this->addReference('value-color-blue', $blueValue);

        /**
         * Small
         */
        $smallValue = $attributeValueFactory
            ->create()
            ->setName('Small')
            ->setDisplayName('Small')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $attributeValueObjectManager->persist($smallValue);
        $this->addReference('value-size-small', $smallValue);

        /**
         * Medium
         */
        $mediumValue = $attributeValueFactory
            ->create()
            ->setName('Medium')
            ->setDisplayName('Medium')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $attributeValueObjectManager->persist($mediumValue);
        $this->addReference('value-size-medium', $mediumValue);

        /**
         * Large
         */
        $largeValue = $attributeValueFactory
            ->create()
            ->setName('Large')
            ->setDisplayName('Large')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $attributeValueObjectManager->persist($largeValue);
        $this->addReference('value-size-large', $largeValue);

        $attributeValueObjectManager->flush([
            $redValue,
            $whiteValue,
            $blueValue,
            $smallValue,
            $mediumValue,
            $largeValue,
        ]);
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
            'Elcodi\Bundle\AttributeBundle\DataFixtures\ORM\AttributeData',
        ];
    }
}
