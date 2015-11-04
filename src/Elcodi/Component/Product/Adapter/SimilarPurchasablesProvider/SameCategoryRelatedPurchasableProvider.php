<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Component\Product\Repository\ProductRepository;

/**
 * Class SameCategoryRelatedPurchasableProvider
 *
 * This adapter takes in account only the principal category of the purchasable.
 * If the purchasable is a Product, then its principal category is used.
 * If the purchasable is a Variant, then its product principal category is used.
 */
class SameCategoryRelatedPurchasableProvider implements RelatedPurchasablesProviderInterface
{
    /**
     * @var ProductRepository
     *
     * Product Repository
     */
    private $productRepository;

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
     * Given a Purchasable, return a collection of related purchasables.
     *
     * @param PurchasableInterface $purchasable Purchasable
     * @param int                  $limit       Limit of elements retrieved
     *
     * @return array Related products
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
        $products = array_reduce($purchasables,
            function ($products, PurchasableInterface $purchasable) {
                $product = $this->getProductByPurchasable($purchasable);
                if ($product instanceof ProductInterface) {
                    return array_merge(
                        $products,
                        [$product]
                    );
                }
            }, []);

        if (
            $limit <= 0 ||
            empty($products)
        ) {
            return [];
        }

        return $this->getRelatedProductsGivenAnArrayOfProducts($products);
    }

    /**
     * Given a purchasable, get it's main product. This purchasable must be an
     * implementation of ProductInterface or VariantInterface. Otherwise the
     * method will return false
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return ProductInterface|false Product instance or false
     */
    private function getProductByPurchasable(PurchasableInterface $purchasable)
    {
        if (
            !($purchasable instanceof ProductInterface) &&
            !($purchasable instanceof VariantInterface)
        ) {
            return false;
        }

        return $purchasable instanceof ProductInterface
            ? $purchasable
            : $purchasable->getProduct();
    }

    /**
     * Build a basic query given a set of categories and a set of unwanted
     * products
     *
     * @return array
     */
    private function getRelatedProductsGivenAnArrayOfProducts(array $products)
    {
        $categories = [];

        /**
         * @var ProductInterface $product
         */
        foreach ($products as $product) {
            $category = $product->getPrincipalCategory();
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
            ->productRepository
            ->createQueryBuilder('p')
            ->select('p', 'v', 'o')
            ->leftJoin('p.variants', 'v')
            ->leftJoin('v.options', 'o')
            ->where("p.principalCategory IN(:categories)")
            ->andWhere("p NOT IN(:products)")
            ->andWhere('p.enabled = :enabled')
            ->setParameters([
                'categories' => $categories,
                'products'   => $products,
                'enabled'    => true,
            ])
            ->getQuery()
            ->getResult();
    }
}
