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

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\NameResolver\Interfaces\PurchasableNameResolverInterface;
use Elcodi\Component\Product\NameResolver\ProductNameResolver;
use Elcodi\Component\Product\NameResolver\PurchasableNameResolver;

/**
 * Class ProductNameResolverTest.
 */
class ProductNameResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolve name.
     *
     * @dataProvider dataResolveName
     */
    public function testResolveName(PurchasableNameResolverInterface $resolver)
    {
        $product = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $product
            ->getName()
            ->willReturn('My Product');

        $this->assertEquals(
            'My Product',
            $resolver->resolveName(
                $product->reveal()
            )
        );
    }

    /**
     * Data for testResolveName.
     */
    public function dataResolveName()
    {
        $productNameResolver = new ProductNameResolver();
        $purchasableNameResolver = new PurchasableNameResolver();
        $purchasableNameResolver->addPurchasableNameResolver($productNameResolver);

        return [
            [$purchasableNameResolver],
            [$productNameResolver],
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
}
