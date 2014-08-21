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

namespace Elcodi\ProductBundle\Tests\UnitTest\Twig;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\AttributeBundle\Entity\Value;
use Elcodi\ProductBundle\Twig\ProductExtension;

class ProductExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Skipping tests if Twig is not installed
     */
    public function setUp()
    {
        if (!class_exists('Twig_Extension')) {

            $this->markTestSkipped("Twig extension not installed");
        }
    }

    /**
     * Test for Product twig extension
     */
    public function testAvailableOptions()
    {
        $product = $this->getMock('Elcodi\ProductBundle\Entity\Product', [], [], '', false);
        $variant = $this->getMock('Elcodi\ProductBundle\Entity\Variant', [], [], '', false);
        $attribute = $this->getMock('Elcodi\AttributeBundle\Entity\Attribute',  [], [], '', false);

        $option = new Value();
        $option->setId(111);
        $option->setAttribute($attribute);

        $product
            ->expects($this->once())
            ->method('getVariants')
            ->willReturn(new ArrayCollection([$variant]));

        $variant
            ->expects($this->once())
            ->method('getStock')
            ->willReturn(100);
        $variant
            ->expects($this->once())
            ->method('IsEnabled')
            ->willReturn(true);
        $variant
            ->expects($this->once())
            ->method('getOptions')
            ->willReturn(new ArrayCollection([$option]));

        $productExtension = new ProductExtension();
        $this->assertEquals(
            new ArrayCollection([$option]),
            $productExtension->getAvailableOptions($product, $attribute)
        );
    }
}
