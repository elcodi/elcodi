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

namespace Elcodi\Component\Product\Tests\UnitTest\ImageResolver;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\ImageResolver\ProductImageResolver;
use Elcodi\Component\Product\ImageResolver\PurchasableImageResolver;

/**
 * Class ProductImageResolverTest.
 */
class ProductImageResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolve image.
     *
     * @dataProvider dataResolveImage
     */
    public function testResolveImage(
        $implementsProduct,
        $imageResolverResult,
        $result
    ) {
        $purchasable = $implementsProduct
            ? $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface')
            : $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $purchasable = $purchasable->reveal();

        $imageResolver = $this->prophesize('Elcodi\Component\Media\Services\ImageResolver');
        $imageResolver->resolveImage($purchasable)->willReturn($imageResolverResult);
        $productImageResolver = new ProductImageResolver($imageResolver->reveal());
        $this->assertSame(
            $result,
            $productImageResolver->getValidImage(
                $purchasable
            )
        );

        $purchasableImageResolver = new PurchasableImageResolver();
        $purchasableImageResolver->addPurchasableImageResolver($productImageResolver);
        $this->assertSame(
            $result,
            $purchasableImageResolver->getValidImage(
                $purchasable
            )
        );
    }

    /**
     * Data for testResolveImage.
     */
    public function dataResolveImage()
    {
        $image = $this
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\MediaInterface')
            ->reveal();

        return [
            'non product' => [false, false, false],
            'product, image not found' => [true, false, false],
            'product, image found' => [true, $image, $image],
        ];
    }
}
