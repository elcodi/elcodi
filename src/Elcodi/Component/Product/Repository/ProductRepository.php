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
use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class ProductRepository
 */
class ProductRepository extends EntityRepository
{
    /**
     * Get all the the products from the received categories
     *
     * @param CategoryInterface[] $categories
     *
     * @return ArrayCollection
     */
    public function getAllFromCategories(
        array $categories
    ) {
        $products = $this
            ->createQueryBuilder('p')
            ->innerJoin('p.categories', 'c')
            ->where('c.id IN (:categories)')
            ->setParameters([
                'categories' => array_values($categories),
            ])
            ->getQuery()
            ->getResult();

        return new ArrayCollection($products);
    }
}
