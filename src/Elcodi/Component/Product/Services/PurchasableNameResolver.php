<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Product\Services;

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class PurchasableNameResolver.
 */
class PurchasableNameResolver
{
    /**
     * @var string
     *
     * Default separator
     */
    const DEFAULT_SEPARATOR = ' - ';

    /**
     * Returns a human readable name for a purchasable, whether Product or
     * Variant is, with all needed information. This value is unique per each
     * type of purchasable element.
     *
     * @param PurchasableInterface $purchasable Purchasable to get name from
     * @param string               $separator   Separator string for product variant options
     *
     * @return string Purchasable name
     */
    public function getPurchasableName(
        PurchasableInterface $purchasable,
        $separator = self::DEFAULT_SEPARATOR
    ) {
        if ($purchasable instanceof ProductInterface) {
            return $purchasable->getName();
        }

        /**
         * @var VariantInterface $purchasable
         */
        $productName = $purchasable->getProduct()->getName();

        foreach ($purchasable->getOptions() as $option) {
            /**
             * @var ValueInterface $option
             */
            $productName .= $separator .
                $option->getAttribute()->getName() .
                ' ' .
                $option->getValue();
        }

        return $productName;
    }
}
