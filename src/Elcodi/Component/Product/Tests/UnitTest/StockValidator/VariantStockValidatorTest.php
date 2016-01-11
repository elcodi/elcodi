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

use Elcodi\Component\Product\StockValidator\PurchasableStockValidator;
use Elcodi\Component\Product\StockValidator\VariantStockValidator;

/**
 * Class VariantStockValidatorTest.
 */
class VariantStockValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test isStockAvailable() with a purchasable non variant.
     */
    public function testIsValidNonVariant()
    {
        $variantValidator = new VariantStockValidator();
        $this->assertFalse(
            $variantValidator->isStockAvailable(
                $this
                    ->prophesize('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface')
                    ->reveal(),
                0,
                false
            )
        );

        $this->assertFalse(
            $variantValidator->isStockAvailable(
                $this
                    ->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface')
                    ->reveal(),
                0,
                false
            )
        );
    }

    /**
     * Test isStockAvailable() with a purchasable non variant.
     *
     * @dataProvider dataIsValidVariant
     */
    public function testIsValidVariant(
        $variantIsEnabled,
        $variantStock,
        $stockRequired,
        $useStock,
        $isValid
    ) {
        $variant = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');
        $variant
            ->isEnabled()
            ->willReturn($variantIsEnabled);
        $variant
            ->getStock()
            ->willReturn($variantStock);
        $variant = $variant->reveal();

        $variantValidator = new VariantStockValidator();
        $this->assertEquals(
            $isValid,
            $variantValidator->isStockAvailable(
                $variant,
                $stockRequired,
                $useStock
            )
        );

        $purchasableValidator = new PurchasableStockValidator();
        $purchasableValidator->addPurchasableStockValidator($variantValidator);
        $this->assertEquals(
            $isValid,
            $purchasableValidator->isStockAvailable(
                $variant,
                $stockRequired,
                $useStock
            )
        );
    }

    /**
     * data for testIsValidVariant.
     */
    public function dataIsValidVariant()
    {
        return [
            'Variant disabled' => [false, 3, 2, true, false],
            'Available stock with stock usage' => [true, 3, 2, true, true],
            'Same stock elements than required' => [true, 3, 3, true, true],
            'Required more elements than stock' => [true, 2, 3, true, 2],
            'Variant without stock' => [true, 0, 3, true, false],
            'Required 0 elements' => [true, 0, 0, true, false],
            'Required more elements that existent with no stock usage' => [true, 2, 3, false, true],
            'Required 0 elements with no stock usage' => [true, 0, 0, false, false],
        ];
    }
}
