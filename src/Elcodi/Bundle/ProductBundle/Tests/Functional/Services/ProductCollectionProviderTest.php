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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Product\Services\ProductCollectionProvider;

/**
 * Tests ProductCollectionProvider class.
 */
class ProductCollectionProviderTest extends WebTestCase
{
    /**
     * @var ProductCollectionProvider
     *
     * Product collection provider
     */
    protected $productCollectionProvider;

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
     * Setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->productCollectionProvider = $this
            ->get('elcodi.provider.product_collection');
    }

    /**
     * Test get home products.
     *
     * @dataProvider dataGetHomeProducts
     */
    public function testGetHomeProducts($count, $numberExpected)
    {
        $products = $this
            ->productCollectionProvider
            ->getHomeProducts($count);

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $products);
        $this->assertEquals($numberExpected, $products->count());
    }

    /**
     * Count values for testGetHomeProducts.
     */
    public function dataGetHomeProducts()
    {
        return [
            [0, 4],
            [1, 1],
            [2, 2],
            [3, 3],
            [4, 4],
            [5, 4],
        ];
    }

    /**
     * Test get home products.
     *
     * @dataProvider dataGetOfferProducts
     */
    public function testGetOfferProducts($count)
    {
        $products = $this
            ->productCollectionProvider
            ->getOfferProducts($count);

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $products);
        $this->assertEquals(1, $products->count());
    }

    /**
     * Count values for testGetOfferProducts.
     */
    public function dataGetOfferProducts()
    {
        return [
            [0],
            [1],
            [2],
        ];
    }
}
