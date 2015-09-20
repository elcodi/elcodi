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

use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class CategoryIntegrityFixer
 */
class CategoryIntegrityFixer
{
    /**
     * Fixes the product categories
     *
     * @param ProductInterface $product The product to fix.
     */
    public function fixProduct(ProductInterface $product)
    {
        $principalCategory = $product->getPrincipalCategory();
        $categories = $product->getCategories();

        if (
            !empty($principalCategory) &&
            !$categories->contains($principalCategory)
        ) {
            /**
             * The product has a principal category but this one is not assigned
             * as product category so this one is added
             */
            $categories->add($principalCategory);
            $product->setCategories($categories);
        } elseif (
            empty($principalCategory) &&
            0 < $categories->count()
        ) {
            /**
             * The product does not have principal category but has categories
             * assigned so the first category is assigned as principal category
             */
            $product->setPrincipalCategory($categories->first());
        }
    }
}
