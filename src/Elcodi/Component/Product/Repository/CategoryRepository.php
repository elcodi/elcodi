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

namespace Elcodi\Component\Product\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * CategoryRepository
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
            ->setParameters(array(
                'root' => true,
            ))
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
     * @param integer $parentCategory The parent category.
     *
     * @return ArrayCollection The list of children categories.
     */
    public function getChildrenCategories($parentCategory)
    {
        $categories = $this
            ->createQueryBuilder('c')
            ->where('c.parent = :parent_category')
            ->setParameters(array(
                'parent_category' => $parentCategory,
            ))
            ->getQuery()
            ->getResult();

        return new ArrayCollection($categories);
    }
}
