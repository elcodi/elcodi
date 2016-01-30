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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Adapter\SimilarPurchasablesProvider;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Product\Adapter\SimilarPurchasablesProvider\SameCategoryRelatedPurchasableProvider;

/**
 * Class SameCategoryRelatedPurchasablesProviderTest.
 */
class SameCategoryRelatedPurchasablesProviderTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiProductBundle',
        ];
    }

    /**
     * Test method getRelatedProducts.
     */
    public function testGetRelatedPurchasables()
    {
        /**
         * @var SameCategoryRelatedPurchasableProvider $relatedPurchasablesProvider
         */
        $relatedPurchasablesProvider = $this->get('elcodi.related_purchasables_provider.same_category');
        $purchasable = $this->find('purchasable', 1);

        /**
         * Testing when limit 0 is requested.
         */
        $this->assertCount(0, $relatedPurchasablesProvider
            ->getRelatedPurchasables($purchasable, 0)
        );

        $purchasables = $relatedPurchasablesProvider->getRelatedPurchasables($purchasable, 1);

        /**
         * Testing when limit 1 is requested with 1 possible elements. We check
         * as well that is not the same product.
         */
        $this->assertCount(1, $purchasables);
        $firstPurchasable = reset($purchasables);
        $this->assertInstanceOf(
            'Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface',
            $firstPurchasable
        );

        /**
         * Testing when limit 3 is requested with 2 possible elements.
         */
        $this->assertCount(2, $relatedPurchasablesProvider
            ->getRelatedPurchasables($purchasable, 2)
        );

        /**
         * Testing with a non valid purchasable instance.
         */
        $purchasable3 = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $this->assertCount(0, $relatedPurchasablesProvider
            ->getRelatedPurchasables($purchasable3, 1)
        );

        /**
         * Testing without categories where to match.
         */
        $this->assertCount(0, $relatedPurchasablesProvider
            ->getRelatedPurchasables(
                $this->find('purchasable', 2),
                1
            )
        );

        /**
         * For this test, we emulate that product 2 has category 1.
         */
        $category2 = $this->find('category', 2);
        $purchasable2 = $this->find('purchasable', 2);
        $purchasable2->setPrincipalCategory($category2);
        $this->flush($purchasable2);

        /**
         * Testing when limit 1 is requested with 2 possible elements.
         */
        $this->assertCount(1, $relatedPurchasablesProvider
            ->getRelatedPurchasables($purchasable, 1)
        );
    }

    /**
     * Test method getRelatedPurchasablesFromArray.
     */
    public function testGetRelatedPurchasablesFromArray()
    {
        /**
         * For this test, we emulate that product 2 has category 1.
         */
        $category1 = $this->find('category', 1);
        $purchasable2 = $this->find('purchasable', 2);
        $purchasable2->setPrincipalCategory($category1);
        $this->flush($purchasable2);

        /**
         * @var SameCategoryRelatedPurchasableProvider $relatedPurchasablesProvider
         */
        $relatedPurchasablesProvider = $this->get('elcodi.related_purchasables_provider.same_category');
        $purchasables = [
            $this->find('purchasable', 1),
            $this->find('purchasable', 2),
        ];

        /**
         * Testing when limit 0 is requested.
         */
        $this->assertCount(0, $relatedPurchasablesProvider
            ->getRelatedPurchasablesFromArray($purchasables, 0)
        );

        /**
         * Testing when limit 1 is requested. More than 0 but less than the
         * total.
         */
        $this->assertCount(1, $relatedPurchasablesProvider
            ->getRelatedPurchasablesFromArray($purchasables, 1)
        );

        $this->assertCount(2, $relatedPurchasablesProvider
            ->getRelatedPurchasablesFromArray($purchasables, 2)
        );

        $this->assertCount(4, $relatedPurchasablesProvider
            ->getRelatedPurchasablesFromArray($purchasables, 5)
        );
    }
}
