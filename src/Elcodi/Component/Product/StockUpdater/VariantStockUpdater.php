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

use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\StockUpdater\Interfaces\PurchasableStockUpdaterInterface;
use Elcodi\Component\Product\StockUpdater\Traits\SimplePurchasableStockUpdaterTrait;

/**
 * Class VariantStockUpdater.
 */
class VariantStockUpdater implements PurchasableStockUpdaterInterface
{
    use SimplePurchasableStockUpdaterTrait;

    /**
     * @var ObjectManager
     *
     * ObjectManager for Variant
     */
    private $variantObjectManager;

    /**
     * Built method.
     *
     * @param ObjectManager $variantObjectManager Variant Object Manager
     */
    public function __construct(ObjectManager $variantObjectManager)
    {
        $this->variantObjectManager = $variantObjectManager;
    }

    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Product\Entity\Interfaces\VariantInterface';
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

        $decreasedStock = $this->updateSimplePurchasableStock(
            $purchasable,
            $stockToDecrease
        );

        $this
            ->variantObjectManager
            ->flush($purchasable);

        return $decreasedStock;
    }
}
