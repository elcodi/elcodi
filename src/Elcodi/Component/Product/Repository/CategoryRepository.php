<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Product\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryRepository
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Get root categories
     *
     * @return ArrayCollection Collection of Root categories
     */
    public function getParentCategories()
    {
        $categories = $this
            ->createQueryBuilder('c')
            ->where('c.root = :root')
            ->setParameters([
                'root' => true,
            ])
            ->getQuery()
            ->getResult();

        return new ArrayCollection($categories);
    }

    /**
     * Get all categories ordered by parent elements and position, ascendant.
     *
     * @return Collection Category collection
     */
    public function getAllCategoriesSortedByParentAndPositionAsc()
    {
        /**
         * @var QueryBuilder
         */
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->addOrderBy('c.parent', 'asc')
            ->addOrderBy('c.position', 'asc');

        $categories = $queryBuilder
            ->getQuery()
            ->getResult();

        return new ArrayCollection($categories);
    }

    /**
     * Get the children categories given a parent category.
     *
     * @param CategoryInterface|null $parentCategory The parent category.
     * @param bool              $recursively    If it should check the
     *                                          children recursively
     *
     * @return ArrayCollection The list of children categories.
     */
    public function getChildrenCategories(
        CategoryInterface $parentCategory = null,
        $recursively = false
    ) {
        $categories = $this
            ->createQueryBuilder('c')
            ->where('c.parent = :parent_category')
            ->setParameters([
                'parent_category' => $parentCategory,
            ])
            ->getQuery()
            ->getResult();

        if ($recursively && !empty($categories)) {
            foreach ($categories as $category) {
                $categories = array_merge(
                    $categories,
                    $this
                        ->getChildrenCategories($category, true)
                        ->toArray()
                );
            }
        }

        return new ArrayCollection($categories);
    }

    /**
     * Get the available parent categories for the received, usually the
     * category itself and all the non root categories are excluded
     *
     * @param integer|null $categoryId The category id
     *
     * @return QueryBuilder
     */
    public function getAvailableParentCategoriesQueryBuilder($categoryId = null)
    {
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->where('c.root = 1');

        if (null !== $categoryId) {
            $queryBuilder
                ->andWhere('c.id <> :parent_category')
                ->setParameter('parent_category', $categoryId);
        }

        return $queryBuilder;
    }
}
