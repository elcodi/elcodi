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

namespace Elcodi\Component\Product\Tests\UnitTest\NameResolver;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\NameResolver\Interfaces\PurchasableNameResolverInterface;
use Elcodi\Component\Product\NameResolver\ProductNameResolver;
use Elcodi\Component\Product\NameResolver\PurchasableNameResolver;
use Elcodi\Component\Product\NameResolver\VariantNameResolver;

/**
 * Class VariantNameResolverTest.
 */
class VariantNameResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolve name.
     *
     * @dataProvider dataResolveName
     */
    public function testResolveName(PurchasableNameResolverInterface $resolver)
    {
        $product = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $variant = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');
        $product
            ->getName()
            ->willReturn('Product Name');

        $variant
            ->getProduct()
            ->willReturn($product->reveal());

        $variant
            ->getName()
            ->willReturn(null);

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
        $variant = $variant->reveal();

        $this->assertEquals(
            'Product Name - attribute1 value1 - attribute2 value2',
            $resolver->resolveName(
                $variant
            )
        );

        $this->assertEquals(
            'Product Name # attribute1 value1 # attribute2 value2',
            $resolver->resolveName(
                $variant,
                ' # '
            )
        );
    }

    /**
     * Data for testResolveName.
     */
    public function dataResolveName()
    {
        $variantNameResolver = new VariantNameResolver();
        $purchasableNameResolver = new PurchasableNameResolver();
        $purchasableNameResolver->addPurchasableNameResolver($variantNameResolver);

        return [
            [$purchasableNameResolver],
            [$variantNameResolver],
        ];
    }

    /**
     * Test resolve name with bad purchasable instance.
     */
    public function testResolveNameBadInstance()
    {
        $purchasable = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $productNameResolver = new ProductNameResolver();
        $this->assertFalse(
            $productNameResolver->resolveName(
                $purchasable->reveal()
            )
        );
    }

    /**
     * Test resolve name.
     *
     * @dataProvider dataResolveName
     */
    public function testResolveNameWithName(PurchasableNameResolverInterface $resolver)
    {
        $variant = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');

        $variant
            ->getName()
            ->willReturn('Variant name');

        $variant = $variant->reveal();

        $this->assertEquals(
            'Variant name',
            $resolver->resolveName(
                $variant
            )
        );

        $this->assertEquals(
            'Variant name',
            $resolver->resolveName(
                $variant,
                ' # '
            )
        );
    }
}
