<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Services;

use Doctrine\DBAL\Query\QueryBuilder;
use Elcodi\CoreBundle\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;

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
     * Set only associated categories
     *
     * @param boolean $loadOnlyCategoriesWithProducts Load only categories with products
     *
     * @return CategoryManager self Object
     */
    public function setLoadOnlyCategoriesWithProducts($loadOnlyCategoriesWithProducts)
    {
        $this->loadOnlyCategoriesWithProducts = $loadOnlyCategoriesWithProducts;

        return $this;
    }

    /**
     * Load method
     *
     * @return CategoryManager self Object
     */
    public function load()
    {
        if ($this->locale) {

            /**
             * Fetch key from cache
             */
            $this->categoryTree = json_decode($this->cache->fetch($this->key), true);

            /**
             * If cache key is empty, build it
             */
            if (empty($this->categoryTree)) {

                $this->categoryTree = $this->buildCategoryTree();
                $this->cache->save($this->key, json_encode($this->categoryTree));
            }
        }

        return $this;
    }

    /**
     * Build category tree from doctrine
     *
     * cost O(n)
     *
     * @return Array Category tree
     */
    public function buildCategoryTree()
    {
        /**
         * @var QueryBuilder
         */
        $queryBuilder = $this
            ->entityManager
            ->getRepository('ElcodiProductBundle:Category')
            ->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->addOrderBy('c.parent', 'asc')
            ->addOrderBy('c.position', 'asc')
            ->setParameters(array(
                'enabled'=> true,
            ));

        if ($this->loadOnlyCategoriesWithProducts) {

            $queryBuilder
                ->innerJoin('c.products', 'p')
                ->andWhere('p.stock > 0')
                ->andWhere('p.enabled = 1');
        }

        $categories = $queryBuilder
            ->getQuery()
            ->getResult();

        $categoryTree = array(
            0   =>  null,
            'children'  =>  array(),
        );

        /**
         * @var CategoryInterface $category
         */
        foreach ($categories as $category) {

            $parentCategoryId = 0;
            $categoryId = $category->getId();

            if (!$category->isRoot()) {
                if ($category->getParent() instanceof CategoryInterface) {
                    $parentCategoryId = $this
                        ->entityManager
                        ->getUnitOfWork()
                        ->getEntityIdentifier($category->getParent())['id'];
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
                    'entity'    =>  null,
                    'children'  =>  array(),
                );
            }

            if (!isset($categoryTree[$categoryId])) {

                $categoryTree[$categoryId] = array(
                    'entity'    =>  null,
                    'children'  =>  array(),
                );
            }

            $categoryTree[$categoryId]['entity'] = array(
                'id'            => $category->getId(),
                'name'          => $category->getName(),
                'slug'          => $category->getSlug(),
                'productsCount' =>    $this->loadOnlyCategoriesWithProducts
                                    ? count($category->getProducts())
                                    : 0
            );

            $categoryTree[$parentCategoryId]['children'][] = &$categoryTree[$categoryId];
        }

        return $categoryTree[0]['children'];
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
}
