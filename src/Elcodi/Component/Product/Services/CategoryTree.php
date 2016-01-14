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

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Repository\CategoryRepository;

/**
 * Class CategoryTree.
 */
class CategoryTree
{
    /**
     * @var CategoryRepository
     *
     * Category repository
     */
    private $categoryRepository;

    /**
     * Construct method.
     *
     * @param CategoryRepository $categoryRepository Category Repository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Builds a category tree with all the categories and subcategories.
     *
     * cost O(n)
     *
     * @return array
     */
    public function buildCategoryTree()
    {
        $categories = $this
            ->categoryRepository
            ->getAllCategoriesSortedByParentAndPositionAsc();

        $categoryTree = [
            0 => null,
            'children' => [],
        ];

        /**
         * @var CategoryInterface $category
         */
        foreach ($categories as $category) {
            $parentCategoryId = 0;
            $categoryId = $category->getId();

            if (!$category->isRoot()) {
                if ($category->getParent() instanceof CategoryInterface) {
                    $parentCategoryId = $category->getParent()->getId();
                } else {

                    /**
                     * If category is not root and has no parent,
                     * don't insert it into the tree.
                     */
                    continue;
                }
            }

            if ($parentCategoryId && !isset($categoryTree[$parentCategoryId])) {
                $categoryTree[$parentCategoryId] = [
                    'entity' => null,
                    'children' => [],
                ];
            }

            if (!isset($categoryTree[$categoryId])) {
                $categoryTree[$categoryId] = [
                    'entity' => null,
                    'children' => [],
                ];
            }

            $categoryTree[$categoryId]['entity'] = $category;

            $categoryTree[$parentCategoryId]['children'][] = &$categoryTree[$categoryId];
        }

        return $categoryTree[0]['children']
            ?: [];
    }
}
