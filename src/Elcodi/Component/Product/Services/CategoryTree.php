<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\Product\Services;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Repository\CategoryRepository;

/**
 * Class CategoryTree
 */
class CategoryTree
{
    /**
     * @var CategoryRepository
     *
     * Category repository
     */
    protected $categoryRepository;

    /**
     * Construct method
     *
     * @param CategoryRepository $categoryRepository Category Repository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Builds a category tree with all the categories and subcategories
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
            0          => null,
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
                     * don't insert it into the tree
                     */
                    continue;
                }
            }

            if ($parentCategoryId && !isset($categoryTree[$parentCategoryId])) {
                $categoryTree[$parentCategoryId] = array(
                    'entity'   => null,
                    'children' => array(),
                );
            }

            if (!isset($categoryTree[$categoryId])) {
                $categoryTree[$categoryId] = array(
                    'entity'   => null,
                    'children' => array(),
                );
            }

            $categoryTree[$categoryId]['entity'] = $category;

            $categoryTree[$parentCategoryId]['children'][] = &$categoryTree[$categoryId];
        }

        return $categoryTree[0]['children']
            ?: [];
    }
}
