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

namespace Elcodi\Component\Product\Adapter\SimilarPurchasablesProvider;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Product\Adapter\SimilarPurchasablesProvider\Interfaces\RelatedPurchasablesProviderInterface;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Repository\PurchasableRepository;

/**
 * Class SameCategoryRelatedPurchasableProvider.
 *
 * This adapter takes in account only the principal category of the purchasable.
 */
class SameCategoryRelatedPurchasableProvider implements RelatedPurchasablesProviderInterface
{
    /**
     * @var PurchasableRepository
     *
     * Purchasable Repository
     */
    private $purchasableRepository;

    /**
     * Construct method.
     *
     * @param PurchasableRepository $purchasableRepository Purchasable Repository
     */
    public function __construct(PurchasableRepository $purchasableRepository)
    {
        $this->purchasableRepository = $purchasableRepository;
    }

    /**
     * Given a Purchasable, return a collection of related purchasables.
     *
     * @param PurchasableInterface $purchasable Purchasable
     * @param int                  $limit       Limit of elements retrieved
     *
     * @return array Related purchasables
     */
    public function getRelatedPurchasables(PurchasableInterface $purchasable, $limit)
    {
        return $this->getRelatedPurchasablesFromArray(
            [$purchasable],
            $limit
        );
    }

    /**
     * Given a Collection of Purchasables, return a collection of related
     * purchasables.
     *
     * @param PurchasableInterface[] $purchasables Purchasable
     * @param int                    $limit        Limit of elements retrieved
     *
     * @return array Related products
     */
    public function getRelatedPurchasablesFromArray(array $purchasables, $limit)
    {
        $categories = [];

        /**
         * @var PurchasableInterface $product
         */
        foreach ($purchasables as $purchasable) {
            $category = $purchasable->getPrincipalCategory();
            if (
                $category instanceof CategoryInterface &&
                !in_array($category, $categories)
            ) {
                $categories[] = $category;
            }
        }

        if (empty($categories)) {
            return [];
        }

        return $this
            ->purchasableRepository
            ->createQueryBuilder('p')
            ->where('p.principalCategory IN(:categories)')
            ->andWhere('p NOT IN(:purchasables)')
            ->andWhere('p.enabled = :enabled')
            ->setParameters([
                'categories' => $categories,
                'purchasables' => $purchasables,
                'enabled' => true,
            ])
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
