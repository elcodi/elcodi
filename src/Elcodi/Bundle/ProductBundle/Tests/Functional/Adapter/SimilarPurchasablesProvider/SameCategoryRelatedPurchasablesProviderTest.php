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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Adapter\SimilarPurchasablesProvider;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Product\Adapter\SimilarPurchasablesProvider\SameCategoryRelatedPurchasableProvider;

/**
 * Class SameCategoryRelatedPurchasablesProviderTest
 */
class SameCategoryRelatedPurchasablesProviderTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiProductBundle',
        ];
    }

    /**
     * Test method getRelatedProducts
     */
    public function testGetRelatedPurchasables()
    {
        /**
         * @var SameCategoryRelatedPurchasableProvider $relatedPurchasablesProvider
         */
        $relatedPurchasablesProvider = $this->get('elcodi.related_purchasables_provider.same_category');
        $product = $this->find('product', 1);

        /**
         * Testing when limit 0 is requested
         */
        $this->assertCount(0, $relatedPurchasablesProvider
            ->getRelatedPurchasables($product, 0)
        );

        $products = $relatedPurchasablesProvider->getRelatedPurchasables($product, 1);

        /**
         * Testing when limit 1 is requested with 1 possible elements. We check
         * as well that is not the same product
         */
        $this->assertCount(1, $products);
        $firstProduct = reset($products);
        $this->assertInstanceOf(
            'Elcodi\Component\Product\Entity\Interfaces\ProductInterface',
            $firstProduct
        );
        $this->assertEquals(3, $firstProduct->getId());

        /**
         * Testing when limit 2 is requested with 1 possible elements
         */
        $this->assertCount(1, $relatedPurchasablesProvider
            ->getRelatedPurchasables($product, 2)
        );

        /**
         * Testing with a non valid purchasable instance
         */
        $purchasable = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $this->assertCount(0, $relatedPurchasablesProvider
            ->getRelatedPurchasables($purchasable, 1)
        );

        /**
         * Testing with a Variant object
         */
        $this->assertCount(1, $relatedPurchasablesProvider
            ->getRelatedPurchasables(
                $this->find('product_variant', 1),
                2
            )
        );

        /**
         * Testing without categories where to match
         */
        $this->assertCount(0, $relatedPurchasablesProvider
            ->getRelatedPurchasables(
                $this->find('product', 2),
                1
            )
        );

        /**
         * For this test, we emulate that product 2 has category 1.
         */
        $category2 = $this->find('category', 2);
        $product2 = $this->find('product', 2);
        $product2->setPrincipalCategory($category2);
        $this->flush($product2);

        /**
         * Testing when limit 1 is requested with 2 possible elements
         */
        $this->assertCount(1, $relatedPurchasablesProvider
            ->getRelatedPurchasables($product, 1)
        );
    }

    /**
     * Test method getRelatedPurchasablesFromArray
     */
    public function testGetRelatedPurchasablesFromArray()
    {
        /**
         * For this test, we emulate that product 2 has category 1.
         */
        $category1 = $this->find('category', 1);
        $product2 = $this->find('product', 2);
        $product2->setPrincipalCategory($category1);
        $this->flush($product2);

        /**
         * @var SameCategoryRelatedPurchasableProvider $relatedPurchasablesProvider
         */
        $relatedPurchasablesProvider = $this->get('elcodi.related_purchasables_provider.same_category');
        $products = [
            $this->find('product', 1),
            $this->find('product', 2),
        ];

        /**
         * Testing when limit 0 is requested
         */
        $this->assertCount(0, $relatedPurchasablesProvider
            ->getRelatedPurchasablesFromArray($products, 0)
        );

        /**
         * Testing when limit 1 is requested. More than 0 but less than the
         * total
         */
        $this->assertCount(1, $relatedPurchasablesProvider
            ->getRelatedPurchasablesFromArray($products, 1)
        );

        $this->assertCount(2, $relatedPurchasablesProvider
            ->getRelatedPurchasablesFromArray($products, 2)
        );

        $this->assertCount(2, $relatedPurchasablesProvider
            ->getRelatedPurchasablesFromArray($products, 3)
        );
    }
}
