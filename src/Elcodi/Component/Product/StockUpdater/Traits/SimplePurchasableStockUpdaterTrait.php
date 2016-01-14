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

namespace Elcodi\Component\Product\StockUpdater\Traits;

use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Trait SimplePurchasableStockUpdaterTrait.
 */
trait SimplePurchasableStockUpdaterTrait
{
    /**
     * Update stock.
     *
     * @param PurchasableInterface $purchasable     Purchasable
     * @param int                  $stockToDecrease Stock to decrease
     *
     * @return false|int Real decreased stock or false if error
     */
    public function updateSimplePurchasableStock(
        PurchasableInterface $purchasable,
        $stockToDecrease
    ) {
        $stock = $purchasable->getStock();
        if (
            $stock === ElcodiProductStock::INFINITE_STOCK ||
            $stockToDecrease <= 0 ||
            $stock <= 0
        ) {
            return false;
        }

        $realStockToDecrease = min($stock, $stockToDecrease);
        $resultingStock = $stock - $realStockToDecrease;
        $purchasable->setStock($resultingStock);

        return $realStockToDecrease;
    }
}
