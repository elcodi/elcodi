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

namespace Elcodi\Component\Product\Tests\UnitTest\StockUpdater;

use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\StockUpdater\ProductStockUpdater;
use Elcodi\Component\Product\StockUpdater\PurchasableStockUpdater;

/**
 * Class ProductStockUpdaterTest.
 */
class ProductStockUpdaterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test update stock with a no product.
     */
    public function testUpdateStockNoProduct()
    {
        $objectManager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');
        $productStockUpdater = new ProductStockUpdater($objectManager->reveal());
        $this->assertFalse(
            $productStockUpdater->updateStock(
                $this
                    ->prophesize('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface')
                    ->reveal(),
                0,
                false
            )
        );

        $this->assertFalse(
            $productStockUpdater->updateStock(
                $this
                    ->prophesize('Elcodi\Component\Product\Entity\Interfaces\VariantInterface')
                    ->reveal(),
                0,
                false
            )
        );
    }

    /**
     * Test update stock.
     *
     * @dataProvider dataUpdateStock
     */
    public function testUpdateStock(
        $actualStock,
        $stockToDecrease,
        $newStock,
        $flush,
        $result
    ) {
        $product = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $product
            ->getStock()
            ->willReturn($actualStock);
        if (!is_null($newStock)) {
            $product->setStock($newStock)->shouldBeCalled();
        }
        $product = $product->reveal();

        $objectManager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');
        if ($flush) {
            $objectManager->flush(Argument::any());
        }

        $productStockUpdater = new ProductStockUpdater($objectManager->reveal());
        $this->assertEquals(
            $result,
            $productStockUpdater->updateStock(
                $product,
                $stockToDecrease
            )
        );

        $purchasableStockUpdater = new PurchasableStockUpdater();
        $purchasableStockUpdater->addPurchasableStockUpdater($productStockUpdater);
        $this->assertEquals(
            $result,
            $purchasableStockUpdater->updateStock(
                $product,
                $stockToDecrease
            )
        );
    }

    /**
     * Data for testUpdateStock.
     */
    public function dataUpdateStock()
    {
        $infStock = ElcodiProductStock::INFINITE_STOCK;

        return [
            'All ok' => [3, 1, 2, true, 1],
            'infinite stock' => [$infStock, 1, null, false, false],
            'We decrease more than existing elements' => [2, 3, 0, true, 2],
        ];
    }
}
