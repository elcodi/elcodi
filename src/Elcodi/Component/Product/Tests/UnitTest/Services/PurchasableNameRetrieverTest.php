<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Product\Tests\UnitTest\Services;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\Services\PurchasableNameResolver;

/**
 * Class PurchasableNameResolverTest.
 */
class PurchasableNameRetrieverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test getPurchasableName with a product.
     */
    public function testGetPurchasableNameWithProduct()
    {
        $purchasableNameResolver = new PurchasableNameResolver();
        $product = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $product
            ->getName()
            ->willReturn('Product Name');

        $this->assertEquals(
            'Product Name',
            $purchasableNameResolver->getPurchasableName(
                $product->reveal()
            )
        );
    }

    /**
     * Test getPurchasableName with a product.
     */
    public function testGetPurchasableNameWithVariant()
    {
        $purchasableNameResolver = new PurchasableNameResolver();
        $product = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $variant = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');
        $product
            ->getName()
            ->willReturn('Product Name');

        $variant
            ->getProduct()
            ->willReturn($product->reveal());

        $attribute1 = $this->prophesize('Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface');
        $attribute1->getName()->willReturn('attribute1');
        $value1 = $this->prophesize('Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface');
        $value1->getAttribute()->willReturn($attribute1->reveal());
        $value1->getValue()->willReturn('value1');

        $attribute2 = $this->prophesize('Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface');
        $attribute2->getName()->willReturn('attribute2');
        $value2 = $this->prophesize('Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface');
        $value2->getAttribute()->willReturn($attribute2->reveal());
        $value2->getValue()->willReturn('value2');

        $variant
            ->getOptions()
            ->willReturn(new ArrayCollection([
                $value1->reveal(),
                $value2->reveal(),
            ]));

        $this->assertEquals(
            'Product Name - attribute1 value1 - attribute2 value2',
            $purchasableNameResolver->getPurchasableName(
                $variant->reveal()
            )
        );

        $this->assertEquals(
            'Product Name # attribute1 value1 # attribute2 value2',
            $purchasableNameResolver->getPurchasableName(
                $variant->reveal(),
                ' # '
            )
        );
    }
}
