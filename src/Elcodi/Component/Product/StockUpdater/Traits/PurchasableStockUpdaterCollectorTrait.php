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

use Traversable;

use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\StockUpdater\Interfaces\PurchasableStockUpdaterInterface;

/**
 * Trait PurchasableStockUpdaterCollectorTrait.
 */
trait PurchasableStockUpdaterCollectorTrait
{
    /**
     * @var PurchasableStockUpdaterInterface[]
     *
     * Stock update stack
     */
    private $stockUpdaters = [];

    /**
     * Add stock updater.
     *
     * @param PurchasableStockUpdaterInterface $stockUpdater Stock updater
     */
    public function addPurchasableStockUpdater(PurchasableStockUpdaterInterface $stockUpdater)
    {
        $this->stockUpdaters[] = $stockUpdater;
    }

    /**
     * Update stock for a set of Purchasable instances given a collection of
     * stock updaters loaded.
     *
     * If all purchasable instances from the collection have been decreased with
     * same value (initial one), then this method will return this value.
     * Otherwise, false.
     *
     * @param Traversable $purchasables    Purchasable
     * @param int         $stockToDecrease Stock to decrease
     *
     * @return false|int
     */
    public function updateStockOfPurchasablesByLoadedStockUpdaters(
        Traversable $purchasables,
        $stockToDecrease
    ) {
        $valid = true;

        foreach ($purchasables as $purchasable) {
            $purchasableResult = $this->updateStockByLoadedStockUpdaters(
                $purchasable,
                $stockToDecrease
            );

            $valid &= ($stockToDecrease === $purchasableResult);
        }

        return $valid
            ? $stockToDecrease
            : false;
    }

    /**
     * Update stock for a Purchasable instance given a collection of stock
     * updaters loaded.
     *
     * @param PurchasableInterface $purchasable     Purchasable
     * @param int                  $stockToDecrease Stock to decrease
     *
     * @return false|int Real decreased stock or false if error
     */
    public function updateStockByLoadedStockUpdaters(
        PurchasableInterface $purchasable,
        $stockToDecrease
    ) {
        foreach ($this->stockUpdaters as $stockUpdater) {
            $stockUpdateNamespace = $stockUpdater->getPurchasableNamespace();
            if ($purchasable instanceof $stockUpdateNamespace) {
                return $stockUpdater->updateStock(
                    $purchasable,
                    $stockToDecrease
                );
            }
        }

        return false;
    }
}
