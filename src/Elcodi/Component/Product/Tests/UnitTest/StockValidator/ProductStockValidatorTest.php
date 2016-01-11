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

namespace Elcodi\Component\Product\Tests\UnitTest\Validator;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\StockValidator\ProductStockValidator;
use Elcodi\Component\Product\StockValidator\PurchasableStockValidator;

/**
 * Class ProductStockValidatorTest.
 */
class ProductStockValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test isStockAvailable() with a purchasable non product.
     */
    public function testIsValidNonProduct()
    {
        $productValidator = new ProductStockValidator();
        $this->assertFalse(
            $productValidator->isStockAvailable(
                $this
                    ->prophesize('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface')
                    ->reveal(),
                0,
                false
            )
        );

        $this->assertFalse(
            $productValidator->isStockAvailable(
                $this
                    ->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface')
                    ->reveal(),
                0,
                false
            )
        );
    }

    /**
     * Test isStockAvailable() with a purchasable non product.
     *
     * @dataProvider dataIsValidProduct
     */
    public function testIsValidProduct(
        $productIsEnabled,
        $productStock,
        $stockRequired,
        $useStock,
        $isValid
    ) {
        $product = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $product
            ->isEnabled()
            ->willReturn($productIsEnabled);
        $product
            ->getStock()
            ->willReturn($productStock);
        $product = $product->reveal();

        $productValidator = new ProductStockValidator();
        $this->assertEquals(
            $isValid,
            $productValidator->isStockAvailable(
                $product,
                $stockRequired,
                $useStock
            )
        );

        $purchasableValidator = new PurchasableStockValidator();
        $purchasableValidator->addPurchasableStockValidator($productValidator);
        $this->assertEquals(
            $isValid,
            $purchasableValidator->isStockAvailable(
                $product,
                $stockRequired,
                $useStock
            )
        );
    }

    /**
     * data for testIsValidProduct.
     */
    public function dataIsValidProduct()
    {
        return [
            'Product disabled' => [false, 3, 2, true, false],
            'Available stock with stock usage' => [true, 3, 2, true, true],
            'Same stock elements than required' => [true, 3, 3, true, true],
            'Required more elements than stock' => [true, 2, 3, true, 2],
            'Product without stock' => [true, 0, 3, true, false],
            'Required 0 elements' => [true, 0, 0, true, false],
            'Required more elements that existent with no stock usage' => [true, 2, 3, false, true],
            'Required 0 elements with no stock usage' => [true, 0, 0, false, false],
        ];
    }
}
