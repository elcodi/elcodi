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

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\ProductBundle\Repository\ProductRepository;

/**
 * Product Collection provider
 *
 * Locale is injected because we can just query products, loading at the same
 * time the corresponding translations.
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
     * @var string
     *
     * Locale
     */
    protected $locale;

    /**
     * Construct method
     *
     * @param ProductRepository $productRepository Product Repository
     * @param string            $locale            Locale
     */
    public function __construct(ProductRepository $productRepository, $locale)
    {
        $this->productRepository = $productRepository;
        $this->locale = $locale;
    }

    /**
     * Get products that can be shown in Home.
     * All products returned are enabled and none deleted
     *
     * @param integer $limit Product limit. By default, this value is 0
     *
     * @return ArrayCollection Set of products, result of the query
     */
    public function getHomeProducts($limit = 0)
    {
        $query = $this
            ->productRepository
            ->createQueryBuilder('p')
            ->select('p', 't', 'm')
            ->leftJoin('p.translations', 't', 'WITH', 'p.id = t.translatable AND t.locale = :locale')
            ->leftJoin('p.principalImage', 'm')
            ->leftJoin('p.items', 'i')
            ->where('p.enabled = :enabled')
            ->andWhere('p.deleted = :deleted')
            ->andWhere("p.showInHome = :inhome")
            ->setParameters(array(
                'enabled'   =>  true,
                'deleted'   =>  false,
                'inhome'    =>  true,
                'locale'    =>  $this->locale,
            ))
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
     * All products returned are enabled and none deleted
     *
     * @param integer $limit Product limit. By default, this value is 0
     *
     * @return ArrayCollection Set of products, result of the query
     */
    public function getOfferProducts($limit = 0)
    {
        $query = $this
            ->productRepository
            ->createQueryBuilder('p')
            ->select('p', 't', 'm')
            ->leftJoin('p.translations', 't', 'WITH', 'p.id = t.translatable AND t.locale = :locale')
            ->leftJoin('p.principalImage', 'm')
            ->leftJoin('p.items', 'i')
            ->where('p.enabled = :enabled')
            ->andWhere('p.deleted = :deleted')
            ->andWhere("i.reducedPrice > 0")
            ->setParameters(array(
                'enabled'   =>  true,
                'deleted'   =>  false,
                'locale'    =>  $this->locale,
            ))
            ->orderBy('p.updatedAt', 'DESC');

        if ($limit > 0) {
            $query->setMaxResults($limit);
        }

        $results = $query
            ->getQuery()
            ->getResult();

        return new ArrayCollection($results);
    }
}
