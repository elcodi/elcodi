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

namespace Elcodi\ProductBundle\Repository;

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
            ->andWhere('c.enabled = :enabled')
            ->setParameters(array(
                'enabled' => true,
                'root'    => true,
            ))
            ->getQuery()
            ->getResult();

        return new ArrayCollection($categories);
    }

    /**
     * Get all categories ordered by parent elements and position, ascendant.
     *
     * @param boolean $loadOnlyCategoriesWithProducts Load only categories with products
     *
     * @return Collection Category collection
     */
    public function getAllCategoriesSortedByParentAndPositionAsc($loadOnlyCategoriesWithProducts)
    {
        /**
         * @var QueryBuilder
         */
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->addOrderBy('c.parent', 'asc')
            ->addOrderBy('c.position', 'asc')
            ->setParameter('enabled', true);

        if ($loadOnlyCategoriesWithProducts) {

            $queryBuilder
                ->innerJoin('c.products', 'p')
                ->andWhere('p.stock > 0')
                ->andWhere('p.enabled = 1');
        }

        $categories = $queryBuilder
            ->getQuery()
            ->getResult();

        return new ArrayCollection($categories);
    }
}
