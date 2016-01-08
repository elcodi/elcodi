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

use Elcodi\Component\Product\Entity\Interfaces\CategorizableInterface;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryIntegrityFixer.
 */
class CategoryIntegrityFixer
{
    /**
     * Fixes all purchasable categories given a set of purchasables.
     *
     * @param CategorizableInterface[] $categorizables Categorizable instances
     */
    public function fixCategoriesIntegrityByArray(array $categorizables)
    {
        foreach ($categorizables as $categorizable) {
            if ($categorizable instanceof CategorizableInterface) {
                $this->fixCategoriesIntegrity($categorizable);
            }
        }
    }

    /**
     * Fixes the categories of a categorizable object.
     *
     * @param CategorizableInterface $categorizable Categorizable instance
     */
    public function fixCategoriesIntegrity(CategorizableInterface $categorizable)
    {
        $principalCategory = $categorizable->getPrincipalCategory();
        $categories = $categorizable->getCategories();

        if ($principalCategory instanceof CategoryInterface) {
            /**
             * The product has a principal category but this one is not assigned
             * as product category so this one is added.
             */
            $categorizable->addCategory($principalCategory);
        } elseif (!$categories->isEmpty()) {

            /**
             * The product does not have principal category but has categories
             * assigned so the first category is assigned as principal category.
             */
            $categorizable->setPrincipalCategory($categories->first());
        }
    }
}
