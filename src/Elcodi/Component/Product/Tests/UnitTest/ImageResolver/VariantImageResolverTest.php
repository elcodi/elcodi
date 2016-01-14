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

use Elcodi\Component\Product\ImageResolver\PurchasableImageResolver;
use Elcodi\Component\Product\ImageResolver\VariantImageResolver;
use Elcodi\Component\Product\Tests\UnitTest\ImageResolver\Abstracts\AbstractImageResolverTest;

/**
 * Class VariantImageResolverTest.
 */
class VariantImageResolverTest extends AbstractImageResolverTest
{
    /**
     * Test resolve image.
     *
     * @dataProvider dataResolveImage
     */
    public function testResolveImage(
        $implementsVariant,
        $imageVariantResolverResult,
        $imageProductResolverResult,
        $result
    ) {
        $purchasable = $implementsVariant
            ? $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface')
            : $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');

        $productImageResolver = $this->getProductImageMock($imageProductResolverResult);

        if ($implementsVariant) {
            $purchasable
                ->getProduct()
                ->willReturn(
                    $this
                        ->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface')
                        ->reveal()
                );
        }
        $purchasable = $purchasable->reveal();

        $imageResolver = $this->prophesize('Elcodi\Component\Media\Services\ImageResolver');
        $imageResolver
            ->resolveImage($purchasable)
            ->willReturn($imageVariantResolverResult);

        $variantImageResolver = new VariantImageResolver($imageResolver->reveal());
        $variantImageResolver->addPurchasableImageResolver($productImageResolver);
        $this->assertSame(
            $result,
            $variantImageResolver->getValidImage(
                $purchasable
            )
        );

        $purchasableImageResolver = new PurchasableImageResolver($imageResolver);
        $purchasableImageResolver->addPurchasableImageResolver($variantImageResolver);
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
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImageInterface')
            ->reveal();

        $anotherImage = $this
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImageInterface')
            ->reveal();

        return [
            'non variant' => [false, false, false, false],
            'variant, image not found, product without images' => [true, false, false, false],
            'variant, image not found, product with images' => [true, false, $image, $image],
            'variant, image found, product without images' => [true, $image, false, $image],
            'variant, image found, product with images' => [true, $image, $anotherImage, $image],
        ];
    }
}
