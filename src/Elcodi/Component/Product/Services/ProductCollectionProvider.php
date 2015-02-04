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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;

use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Repository\ProductRepository;

/**
 * Product Collection provider
 *
 * Locale is injected because we can just query products.
 */
class ProductCollectionProvider
{
    /**
     * @var ProductRepository
     *
     * Product Repository
     */
    protected $productRepository;

    /**
     * Construct method
     *
     * @param ProductRepository $productRepository Product Repository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get products that can be shown in Home.
     * All products returned are
     * * enabled
     * * with stock > 0
     * * with stock infinite
     *
     * @param integer $limit Product limit. By default, this value is 0
     *
     * @return ArrayCollection Set of products, result of the query
     */
    public function getHomeProducts($limit = 0)
    {
        $queryBuilder = $this
            ->productRepository
            ->createQueryBuilder('p');

        $this->addStockPropertiesToQueryBuilder($queryBuilder);

        $query = $queryBuilder
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.showInHome = :showInHome')
            ->setParameter('enabled', true)
            ->setParameter('showInHome', true)
            ->orderBy('p.updatedAt', 'DESC');

        if ($limit > 0) {
            $query->setMaxResults($limit);
        }

        $results = $query
            ->getQuery()
            ->getResult();

        return new ArrayCollection($results);
    }

    /**
     * Get products with price reduction.
     * All products returned are activated and none deleted
     *
     * @param integer $limit Product limit. By default, this value is 0
     *
     * @return ArrayCollection Set of products, result of the query
     */
    public function getOfferProducts($limit = 0)
    {
        $queryBuilder = $this
            ->productRepository
            ->createQueryBuilder('p');

        $this->addStockPropertiesToQueryBuilder($queryBuilder);

        $query = $queryBuilder
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.reducedPrice > 0')
            ->andWhere('p.reducedPrice IS NOT NULL')
            ->setParameter('enabled', true)
            ->orderBy('p.updatedAt', 'DESC');

        if ($limit > 0) {
            $query->setMaxResults($limit);
        }

        $results = $query
            ->getQuery()
            ->getResult();

        return new ArrayCollection($results);
    }

    /**
     * Add stock properties to query builder
     *
     * @param QueryBuilder $queryBuilder QueryBuilder
     *
     * @return QueryBuilder same object
     */
    protected function addStockPropertiesToQueryBuilder(QueryBuilder $queryBuilder)
    {
        $infiniteStockIsNull = is_null(ElcodiProductStock::INFINITE_STOCK);

        $queryBuilder
            ->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->gt('p.stock', ':stockZero'),
                $infiniteStockIsNull
                    ? $queryBuilder->expr()->isNull('p.stock')
                    : $queryBuilder->expr()->eq('p.stock', ':infiniteStock')
            ))
            ->setParameter('stockZero', 0);

        if (!$infiniteStockIsNull) {
            $queryBuilder->setParameter('infiniteStock', ElcodiProductStock::INFINITE_STOCK);
        }

        return $queryBuilder;
    }
}
