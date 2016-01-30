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

namespace Elcodi\Component\Product\Services;

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

@trigger_error('This class is deprecated since version v1.0.15 and will be
removed in v2.0.0. Use
Elcodi\Component\Product\NameResolver\PurchasableNameResolver instead',
    E_USER_DEPRECATED);

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
        /**
         * Resolver for product.
         */
        if ($purchasable instanceof ProductInterface) {
            return $this->resolveProductName($purchasable);
        }

        /**
         * Resolver for variant.
         */
        if ($purchasable instanceof VariantInterface) {
            return $this->resolveVariantName(
                $purchasable,
                $separator
            );
        }

        /**
         * Resolver for variant.
         */
        if ($purchasable instanceof PackInterface) {
            return $this->resolvePackName($purchasable);
        }
    }

    /**
     * Resolve name for product.
     *
     * @param ProductInterface $product Product
     *
     * @return string Resolve product name
     */
    private function resolveProductName(ProductInterface $product)
    {
        return $product->getName();
    }

    /**
     * Resolve name for variant.
     *
     * @param VariantInterface $variant   Variant
     * @param string           $separator Separator string for product variant options
     *
     * @return string Resolve product name
     */
    private function resolveVariantName(
        VariantInterface $variant,
        $separator = self::DEFAULT_SEPARATOR)
    {
        $variantName = $variant->getProduct()->getName();

        foreach ($variant->getOptions() as $option) {
            /**
             * @var ValueInterface $option
             */
            $variantName .= $separator .
                $option->getAttribute()->getName() .
                ' ' .
                $option->getValue();
        }

        return $variantName;
    }

    /**
     * Resolve name for pack.
     *
     * @param PackInterface $pack Pack
     *
     * @return string Resolve pack name
     */
    private function resolvePackName(PackInterface $pack)
    {
        return $pack->getName();
    }
}
