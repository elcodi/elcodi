<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\AttributeBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class AttributeData.
 */
class AttributeData extends AbstractFixture
{
    /**
     * Loads sample fixtures for Attribute entities.
     *
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        /**
         * @var ObjectDirector $attributeDirector
         * @var ObjectDirector $attributeValueDirector
         */
        $attributeDirector = $this->getDirector('attribute');
        $attributeValueDirector = $this->getDirector('attribute_value');

        /**
         * Sizes.
         */
        $sizeAttribute = $attributeDirector
            ->create()
            ->setName('Size')
            ->setEnabled(true);

        $attributeDirector->save($sizeAttribute);
        $this->addReference('attribute-size', $sizeAttribute);

        $smallValue = $attributeValueDirector
            ->create()
            ->setValue('Small')
            ->setAttribute($sizeAttribute);

        $attributeValueDirector->save($smallValue);
        $this->addReference('value-size-small', $smallValue);

        $mediumValue = $attributeValueDirector
            ->create()
            ->setValue('Medium')
            ->setAttribute($sizeAttribute);

        $attributeValueDirector->save($mediumValue);
        $this->addReference('value-size-medium', $mediumValue);

        $largeValue = $attributeValueDirector
            ->create()
            ->setValue('Large')
            ->setAttribute($sizeAttribute);

        $attributeValueDirector->save($largeValue);
        $this->addReference('value-size-large', $largeValue);

        /**
         * Colors.
         */
        $colorAttribute = $attributeDirector
            ->create()
            ->setName('Color')
            ->setEnabled(true);

        $attributeDirector->save($colorAttribute);
        $this->addReference('attribute-color', $colorAttribute);

        $blueValue = $attributeValueDirector
            ->create()
            ->setValue('Blue')
            ->setAttribute($colorAttribute);

        $attributeValueDirector->save($blueValue);
        $this->addReference('value-color-blue', $blueValue);

        $whiteValue = $attributeValueDirector
            ->create()
            ->setValue('White')
            ->setAttribute($colorAttribute);

        $attributeValueDirector->save($whiteValue);
        $this->addReference('value-color-white', $whiteValue);

        $redValue = $attributeValueDirector
            ->create()
            ->setValue('Red')
            ->setAttribute($colorAttribute);

        $attributeValueDirector->save($redValue);
        $this->addReference('value-color-red', $redValue);
    }
}
