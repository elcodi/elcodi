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

namespace Elcodi\Component\Product\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class PurchasableRepository.
 */
class PurchasableRepository extends EntityRepository
{
    /**
     * Get all the the Purchasables from the received categories.
     *
     * @param CategoryInterface[] $categories
     *
     * @return array All Purchasables by a set of category ids
     */
    public function getAllFromCategories(array $categories)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $this->addPerformanceJoinsToQueryBuilder($queryBuilder);

        return $queryBuilder
            ->innerJoin('p.categories', 'c')
            ->where('c.id IN (:categories)')
            ->setParameters([
                'categories' => $categories,
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * Get purchasables that can be shown in Home.
     *
     * @param int  $limit    Purchasable limit. By default, this value is 0
     * @param bool $useStock Use stock
     *
     * @return array Set of Purchasables, result of the query
     */
    public function getHomePurchasables(
        $limit = 0,
        $useStock = true
    ) {
        $queryBuilder = $this->createQueryBuilder('p');

        $this->addPerformanceJoinsToQueryBuilder($queryBuilder);
        $this->addStockPropertiesToQueryBuilder(
            $queryBuilder,
            $useStock
        );

        $query = $queryBuilder
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.showInHome = :showInHome')
            ->setParameter('enabled', true)
            ->setParameter('showInHome', true)
            ->orderBy('p.updatedAt', 'DESC');

        if ($limit > 0) {
            $query->setMaxResults($limit);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    /**
     * Get purchasables with price reduction.
     * All purchasables returned are activated and none deleted.
     *
     * @param int  $limit    Purchasable limit. By default, this value is 0
     * @param bool $useStock Use stock
     *
     * @return array Set of Purchasables, result of the query
     */
    public function getOfferPurchasables(
        $limit = 0,
        $useStock = true
    ) {
        $queryBuilder = $this->createQueryBuilder('p');

        $this->addPerformanceJoinsToQueryBuilder($queryBuilder);
        $this->addStockPropertiesToQueryBuilder(
            $queryBuilder,
            $useStock
        );

        $query = $queryBuilder
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.reducedPrice > 0')
            ->andWhere('p.reducedPrice IS NOT NULL')
            ->setParameter('enabled', true)
            ->orderBy('p.updatedAt', 'DESC');

        if ($limit > 0) {
            $query->setMaxResults($limit);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    /**
     * Add stock properties to query builder.
     *
     * @param QueryBuilder $queryBuilder QueryBuilder
     * @param bool         $useStock     Use stock
     */
    private function addStockPropertiesToQueryBuilder(
        QueryBuilder $queryBuilder,
        $useStock
    ) {
        if ($useStock) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->orX(
                    $queryBuilder->expr()->gt('p.stock', ':stockZero'),
                    $queryBuilder->expr()->eq('p.stock', ':infiniteStock')
                ))
                ->setParameter(
                    'stockZero',
                    0
                )
                ->setParameter(
                    'infiniteStock',
                    ElcodiProductStock::INFINITE_STOCK
                );
        }
    }

    /**
     * Add performance joins.
     *
     * This method decorates the query builder with non-changing left joins,
     * only for increasing the performance impact for post lazy queries.
     *
     * @param QueryBuilder $queryBuilder QueryBuilder
     */
    private function addPerformanceJoinsToQueryBuilder(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->select(['p', 'pa', 'pc', 'rpc', 'i'])
            ->leftJoin('p.principalImage', 'pa')
            ->leftJoin('p.priceCurrency', 'pc')
            ->leftJoin('p.reducedPriceCurrency', 'rpc')
            ->leftJoin('p.images', 'i')
            ->groupBy('p.id');
    }
}
