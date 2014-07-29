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

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;

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
     * @var EntityManagerInterface
     *
     * Category entity manager
     */
    protected $categoryEntityManager;

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
     * @param EntityManagerInterface $categoryEntityManager          Category entity manager
     * @param CategoryRepository     $categoryRepository             Category Repository
     * @param boolean                $loadOnlyCategoriesWithProducts Load only categories with products
     * @param string                 $key                            Key where to store info
     */
    public function __construct(
        EntityManagerInterface $categoryEntityManager,
        CategoryRepository $categoryRepository,
        $loadOnlyCategoriesWithProducts,
        $key
    )
    {
        $this->categoryEntityManager = $categoryEntityManager;
        $this->categoryRepository = $categoryRepository;
        $this->loadOnlyCategoriesWithProducts = $loadOnlyCategoriesWithProducts;
        $this->key = $key;
    }

    /**
     * Load method
     *
     * @return array Category tree loaded
     */
    public function load()
    {
        /**
         * Fetch key from cache
         */
        $this->categoryTree = $this
            ->encoder
            ->decode(
                $this
                    ->cache
                    ->fetch($this->key)
            );

        /**
         * If cache key is empty, build it
         */
        if (empty($this->categoryTree)) {

            $this->categoryTree = $this->buildCategoryTree();
            $this
                ->cache
                ->save(
                    $this->key,
                    $this->encoder->encode($this->categoryTree)
                );
        }

        return $this->categoryTree;
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
            ->categoryRepository
            ->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->addOrderBy('c.parent', 'asc')
            ->addOrderBy('c.position', 'asc')
            ->setParameters(array(
                'enabled' => true,
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
            0          => null,
            'children' => array(),
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
                        ->categoryEntityManager
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
