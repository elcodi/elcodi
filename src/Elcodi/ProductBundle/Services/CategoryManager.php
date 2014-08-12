<?php

/**
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

namespace Elcodi\ProductBundle\Services;

use Elcodi\CoreBundle\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\ProductBundle\Repository\CategoryRepository;

/**
 * Categories manager service
 *
 * Manages category tree and stores it in a redis key.
 *
 * To disable this features, use an "Array" cache type for this profile
 */
class CategoryManager extends AbstractCacheWrapper
{
    /**
     * @var array
     *
     * Category tree
     */
    protected $categoryTree;

    /**
     * @var boolean
     *
     * Load only categories with products
     */
    protected $loadOnlyCategoriesWithProducts;

    /**
     * @var CategoryRepository
     *
     * Category repository
     */
    protected $categoryRepository;

    /**
     * @var string
     *
     * Key
     */
    protected $key;

    /**
     * Construct method
     *
     * @param CategoryRepository $categoryRepository             Category Repository
     * @param boolean            $loadOnlyCategoriesWithProducts Load only categories with products
     * @param string             $key                            Key where to store info
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        $loadOnlyCategoriesWithProducts,
        $key
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->loadOnlyCategoriesWithProducts = $loadOnlyCategoriesWithProducts;
        $this->key = $key;
    }

    /**
     * Get category tree
     *
     * @return array Category tree
     */
    public function getCategoryTree()
    {
        return $this->categoryTree;
    }

    /**
     * Load Category tree from cache.
     *
     * If element is not loaded yet, loads it from Database and store it into
     * cache.
     *
     * @return array Category tree loaded
     */
    public function load()
    {
        if (is_array($this->categoryTree)) {
            return $this->categoryTree;
        }

        /**
         * Fetch key from cache
         */
        $categoryTree = $this->loadCategoryTreeFromCache();

        /**
         * If cache key is empty, build it
         */
        if (empty($categoryTree)) {

            $categoryTree = $this->buildCategoryTreeAndSaveIntoCache();
        }

        $this->categoryTree = $categoryTree;

        return $categoryTree;
    }

    /**
     * Reload Category tree from cache
     *
     * Empty cache and load again
     *
     * @return array Category tree loaded
     */
    public function reload()
    {
        $this
            ->cache
            ->delete($this->key);

        $this->categoryTree = null;

        return $this->load();
    }

    /**
     * Load category tree from cache
     *
     * @return array Category tree
     */
    protected function loadCategoryTreeFromCache()
    {
        return $this
            ->encoder
            ->decode(
                $this
                    ->cache
                    ->fetch($this->key)
            );
    }

    /**
     * Build category tree and save it into cache
     *
     * @return array Category tree
     */
    protected function buildCategoryTreeAndSaveIntoCache()
    {
        $categoryTree = $this->buildCategoryTree();
        $this->saveCategoryTreeIntoCache($categoryTree);

        return $categoryTree;
    }

    /**
     * Build category tree from doctrine
     *
     * cost O(n)
     *
     * @return Array Category tree
     */
    protected function buildCategoryTree()
    {
        $categories = $this
            ->categoryRepository
            ->getAllCategoriesSortedByParentAndPositionAsc(
                $this->loadOnlyCategoriesWithProducts
            );

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

            $categoryTree[$categoryId]['entity'] = array(
                'id'            => $category->getId(),
                'name'          => $category->getName(),
                'slug'          => $category->getSlug(),
                'productsCount' => $this->loadOnlyCategoriesWithProducts
                        ? count($category->getProducts())
                        : 0
            );

            $categoryTree[$parentCategoryId]['children'][] = & $categoryTree[$categoryId];
        }

        return $categoryTree[0]['children']
            ? : [];
    }

    /**
     * Save given category tree into cache
     *
     * @param array $categoryTree Category tree
     *
     * @return CategoryManager self Object
     */
    protected function saveCategoryTreeIntoCache($categoryTree)
    {
        $this
            ->cache
            ->save(
                $this->key,
                $this->encoder->encode($categoryTree)
            );

        return $this;
    }
}
