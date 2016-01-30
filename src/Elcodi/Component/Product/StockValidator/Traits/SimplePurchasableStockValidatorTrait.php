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

namespace Elcodi\Component\Product\StockValidator\Traits;

use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Trait SimplePurchasableStockValidatorTrait.
 */
trait SimplePurchasableStockValidatorTrait
{
    /**
     * Make a simple validation of a Purchasable instance.
     *
     * @param PurchasableInterface $purchasable   Purchasable
     * @param int                  $stockRequired Stock required
     * @param bool                 $useStock      Use stock
     *
     * @return bool|int Is valid or the number of elements that can be used
     */
    public function isValidUsingSimplePurchasableValidation(
        PurchasableInterface $purchasable,
        $stockRequired,
        $useStock
    ) {
        if (
            !$purchasable->isEnabled() ||
            $stockRequired <= 0 ||
            (
                $useStock &&
                $purchasable->getStock() <= 0
            )
        ) {
            return false;
        }

        if ($purchasable->getStock() < $stockRequired) {
            return $purchasable->getStock();
        }

        return true;
    }
}
