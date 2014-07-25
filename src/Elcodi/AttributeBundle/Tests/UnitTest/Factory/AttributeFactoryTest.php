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

namespace Elcodi\AttributeBundle\Tests\UnitTest\Factory;

use Elcodi\AttributeBundle\Factory\AttributeFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class AttributeFactoryTest
 */
class AttributeFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test object creation
     *
     * @group attribute
     */
    public function testCreate()
    {
        $attributeFactory = new AttributeFactory();
        $attributeFactory
            ->setEntityNamespace('Elcodi\AttributeBundle\Entity\Attribute');

        $attribute = $attributeFactory->create();

        $this->assertInstanceOf('Elcodi\AttributeBundle\Entity\Attribute', $attribute);
    }
}
