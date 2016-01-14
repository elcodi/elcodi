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

namespace Elcodi\Component\Product\Tests\UnitTest\ImageResolver\Abstracts;

use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Product\ImageResolver\ProductImageResolver;
use Elcodi\Component\Product\ImageResolver\VariantImageResolver;

/**
 * Class AbstractImageResolverTest.
 */
abstract class AbstractImageResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Get product image resolver mock.
     *
     * @param ImageInterface|false $image Image
     *
     * @return ProductImageResolver
     */
    protected function getProductImageMock($image)
    {
        $productImageResolver = $this->prophesize('Elcodi\Component\Product\ImageResolver\ProductImageResolver');
        $productImageResolver
            ->getValidImage(Argument::any())
            ->willReturn($image);

        $productImageResolver
            ->getPurchasableNamespace()
            ->willReturn('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');

        return $productImageResolver->reveal();
    }

    /**
     * Get variant image resolver mock.
     *
     * @param ImageInterface|false $image Image
     *
     * @return VariantImageResolver
     */
    protected function getVariantImageMock($image)
    {
        $variantImageResolver = $this->prophesize('Elcodi\Component\Product\ImageResolver\VariantImageResolver');
        $variantImageResolver
            ->getValidImage(Argument::any())
            ->willReturn($image);

        $variantImageResolver
            ->getPurchasableNamespace()
            ->willReturn('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');

        return $variantImageResolver->reveal();
    }
}
