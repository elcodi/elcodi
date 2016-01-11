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

namespace Elcodi\Component\Product\Adapter\SimilarPurchasablesProvider\Interfaces;

use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Interface RelatedPurchasablesProviderInterface.
 */
interface RelatedPurchasablesProviderInterface
{
    /**
     * Given a Purchasable, return a collection of related purchasables.
     *
     * @param PurchasableInterface $purchasable Purchasable
     * @param int                  $limit       Limit of elements retrieved
     *
     * @return array Related products
     */
    public function getRelatedPurchasables(PurchasableInterface $purchasable, $limit);

    /**
     * Given a Collection of Purchasables, return a collection of related
     * purchasables.
     *
     * @param PurchasableInterface[] $purchasables Purchasable
     * @param int                    $limit        Limit of elements retrieved
     *
     * @return array Related products
     */
    public function getRelatedPurchasablesFromArray(array $purchasables, $limit);
}
