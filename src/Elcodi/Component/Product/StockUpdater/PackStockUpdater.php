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

namespace Elcodi\Component\Product\StockUpdater;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\StockUpdater\Interfaces\PurchasableStockUpdaterInterface;
use Elcodi\Component\Product\StockUpdater\Traits\PurchasableStockUpdaterCollectorTrait;
use Elcodi\Component\Product\StockUpdater\Traits\SimplePurchasableStockUpdaterTrait;

/**
 * Class PackStockUpdater.
 */
class PackStockUpdater implements PurchasableStockUpdaterInterface
{
    use PurchasableStockUpdaterCollectorTrait,
        SimplePurchasableStockUpdaterTrait;

    /**
     * @var ObjectManager
     *
     * ObjectManager for Pack
     */
    private $packObjectManager;

    /**
     * Built method.
     *
     * @param ObjectManager $packObjectManager Pack Object Manager
     */
    public function __construct(ObjectManager $packObjectManager)
    {
        $this->packObjectManager = $packObjectManager;
    }

    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Product\Entity\Interfaces\PackInterface';
    }

    /**
     * Update stock.
     *
     * @param PurchasableInterface $purchasable     Purchasable
     * @param int                  $stockToDecrease Stock to decrease
     *
     * @return false|int Real decreased stock or false if error
     */
    public function updateStock(
        PurchasableInterface $purchasable,
        $stockToDecrease
    ) {
        $namespace = $this->getPurchasableNamespace();
        if (!$purchasable instanceof $namespace) {
            return false;
        }

        /**
         * @var $purchasable PackInterface
         */
        $stockType = $purchasable->getStockType();
        if ($stockType === ElcodiProductStock::INHERIT_STOCK) {
            return $this->updateStockOfPurchasablesByLoadedStockUpdaters(
                $purchasable->getPurchasables(),
                $stockToDecrease
            );
        }

        $decreasedStock = $this->updateSimplePurchasableStock(
            $purchasable,
            $stockToDecrease
        );

        if ($decreasedStock) {
            $this
                ->packObjectManager
                ->flush($purchasable);
        }

        return $decreasedStock;
    }
}
