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
         * @var AttributeFactory $attributeFactory
         */
        $attributeFactory = $this->getFactory('attribute');
        $attributeObjectManager = $this->getObjectManager('attribute');

        $sizeAttribute = $attributeFactory
            ->create()
            ->setName('Size')
            ->setDisplayName('Size')
            ->setEnabled(true);

        $attributeObjectManager->persist($sizeAttribute);
        $this->addReference('attribute-size', $sizeAttribute);

        $colorAttribute = $attributeFactory
            ->create()
            ->setName('Color')
            ->setDisplayName('Color')
            ->setEnabled(true);

        $attributeObjectManager->persist($colorAttribute);
        $this->addReference('attribute-color', $colorAttribute);

        $attributeObjectManager->flush([
            $sizeAttribute,
            $colorAttribute,
        ]);
    }
}
