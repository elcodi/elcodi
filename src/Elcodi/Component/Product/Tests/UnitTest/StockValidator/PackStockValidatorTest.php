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

namespace Elcodi\Component\Product\Tests\UnitTest\StockValidator;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\StockValidator\PackStockValidator;
use Elcodi\Component\Product\StockValidator\ProductStockValidator;
use Elcodi\Component\Product\StockValidator\PurchasableStockValidator;
use Elcodi\Component\Product\StockValidator\VariantStockValidator;

/**
 * Class PackStockValidatorTest.
 */
class PackStockValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test isStockAvailable() with a purchasable non pack.
     */
    public function testIsValidNonPack()
    {
        $packValidator = new PackStockValidator();
        $this->assertFalse(
            $packValidator->isStockAvailable(
                $this
                    ->prophesize('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface')
                    ->reveal(),
                0,
                false
            )
        );

        $this->assertFalse(
            $packValidator->isStockAvailable(
                $this
                    ->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface')
                    ->reveal(),
                0,
                false
            )
        );
    }

    /**
     * Test isStockAvailable() with a purchasable non pack.
     *
     * @dataProvider dataIsValidPack
     */
    public function testIsValidPack(
        $packIsEnabled,
        $packType,
        $packStock,
        $productIsEnabled,
        $productStock,
        $variantIsEnabled,
        $variantStock,
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

        $variant = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');
        $variant
            ->isEnabled()
            ->willReturn($variantIsEnabled);
        $variant
            ->getStock()
            ->willReturn($variantStock);

        $pack = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\PackInterface');
        $pack
            ->isEnabled()
            ->willReturn($packIsEnabled);

        $pack
            ->getStockType()
            ->willReturn($packType);
        $pack
            ->getStock()
            ->willReturn($packStock);
        $pack
            ->getPurchasables()
            ->willReturn(new ArrayCollection([
                $product->reveal(),
                $variant->reveal(),
            ]));

        $pack = $pack->reveal();
        $packValidator = new PackStockValidator();
        $packValidator->addPurchasableStockValidator(new ProductStockValidator());
        $packValidator->addPurchasableStockValidator(new VariantStockValidator());

        $this->assertEquals(
            $isValid,
            $packValidator->isStockAvailable(
                $pack,
                $stockRequired,
                $useStock
            )
        );

        $purchasableValidator = new PurchasableStockValidator();
        $purchasableValidator->addPurchasableStockValidator(new ProductStockValidator());
        $purchasableValidator->addPurchasableStockValidator(new VariantStockValidator());
        $purchasableValidator->addPurchasableStockValidator($packValidator);
        $this->assertEquals(
            $isValid,
            $purchasableValidator->isStockAvailable(
                $pack,
                $stockRequired,
                $useStock
            )
        );
    }

    /**
     * data for testIsValidPack.
     */
    public function dataIsValidPack()
    {
        $inhStock = ElcodiProductStock::INHERIT_STOCK;
        $spcStock = ElcodiProductStock::SPECIFIC_STOCK;

        return [
            'Pack disabled' => [false, $spcStock, 3, true, 3, true, 3, 2, false, false],

            // Without inheritance stock
            'Non inh: one of them disabled' => [true, $spcStock, 3, false, 3, true, 3, 2, true, false],
            'Non inh: both of them disabled' => [true, $spcStock, 3, false, 3, false, 3, 2, true, false],
            'Non inh: Available stock with stock usage' => [true, $spcStock, 3, true, 3, true, 3, 2, true, true],
            'Non inh: Same stock elements than required' => [true, $spcStock, 3, true, 3, true, 3, 3, true, true],
            'Non inh: Required more elements than stock' => [true, $spcStock, 2, true, 3, true, 3, 3, true, 2],
            'Non inh: Pack without stock' => [true, $spcStock, 0, true, 3, true, 3, 3, true, false],
            'Non inh: Required 0 elements' => [true, $spcStock, 3, true, 3, true, 3, 0, true, false],
            'Non inh: Required more elements that existent with no stock usage' => [true, $spcStock, 2, true, 3, true, 3, 3, false, true],
            'Non inh: Required 0 elements with no stock usage' => [true, $spcStock, 2, true, 3, true, 3, 0, false, false],

            // With inheritance stock + Variant enabled and stock 3
            // Changes only product
            'Prod: Product disabled' => [true, $inhStock, null, false, 3, true, 3, 2, true, false],
            'Prod: Available stock with stock usage' => [true, $inhStock, null, true, 3, true, 3, 2, true, true],
            'Prod: Same stock elements than required' => [true, $inhStock, null, true, 3, true, 3, 3, true, true],
            'Prod: Required more elements than stock' => [true, $inhStock, null, true, 2, true, 3, 3, true, 2],
            'Prod: Required much more elements than stock' => [true, $inhStock, null, true, 2, true, 4, 3, true, 2],
            'Prod: Product without stock' => [true, $inhStock, null, true, 0, true, 3, 3, true, false],
            'Prod: Required 0 elements' => [true, $inhStock, null, true, 0, true, 3, 0, true, false],
            'Prod: Required more elements that existent with no stock usage' => [true, $inhStock, null, true, 2, true, 3, 3, false, true],
            'Prod: Required 0 elements with no stock usage' => [true, $inhStock, null, true, 0, true, 3, 0, false, false],

            // With inheritance stock + Product enabled and stock 3
            // Changes only variant
            'Var: Variant disabled' => [true, $inhStock, null, true, 3, false, 3, 2, true, false],
            'Var: Available stock with stock usage' => [true, $inhStock, null, true, 3, true, 3, 2, true, true],
            'Var: Same stock elements than required' => [true, $inhStock, null, true, 3, true, 3, 3, true, true],
            'Var: Required more elements than stock' => [true, $inhStock, null, true, 3, true, 2, 3, true, 2],
            'Var: Variant without stock' => [true, $inhStock, null, true, 3, true, 0, 3, true, false],
            'Var: Required 0 elements' => [true, $inhStock, null, true, 3, true, 0, 0, true, false],
            'Var: Required more elements that existent with no stock usage' => [true, $inhStock, null, true, 3, true, 2, 3, false, true],
            'Var: Required 0 elements with no stock usage' => [true, $inhStock, null, true, 3, true, 0, 0, false, false],
        ];
    }
}
