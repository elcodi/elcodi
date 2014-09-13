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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Product\Services\ProductCollectionProvider;

/**
 * Tests ProductCollectionProvider class
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
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiProductBundle',
        );
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.product.service.product_collection_provider',
            'elcodi.product_collection_provider',
        ];
    }

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        $this->productCollectionProvider = $this
            ->get('elcodi.product_collection_provider');
    }

    /**
     * Test get home products
     *
     * @dataProvider dataGetHomeProducts
     */
    public function testGetHomeProducts($count)
    {
        $products = $this
            ->productCollectionProvider
            ->getHomeProducts($count);

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $products);
        $this->assertEquals(1, $products->count());
    }

    /**
     * Count values for testGetHomeProducts
     */
    public function dataGetHomeProducts()
    {
        return [
            [0],
            [1],
            [2],
        ];
    }

    /**
     * Test get home products
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
     * Count values for testGetHomeProducts
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
