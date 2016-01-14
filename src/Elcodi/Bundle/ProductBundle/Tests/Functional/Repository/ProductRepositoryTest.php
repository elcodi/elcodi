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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Repository;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Repository\CategoryRepository;
use Elcodi\Component\Product\Repository\ProductRepository;

/**
 * Class ProductRepositoryTest.
 */
class ProductRepositoryTest extends WebTestCase
{
    /**
     * @var CategoryRepository
     *
     * LocationProvider class
     */
    protected $categoryRepository;

    /**
     * @var ProductRepository
     *
     * LocationProvider class
     */
    protected $productRepository;

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

        $this->productRepository = $this->get('elcodi.repository.product');
        $this->categoryRepository = $this->get('elcodi.repository.category');
    }

    /**
     * Test product repository provider.
     */
    public function testRepositoryProvider()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\ObjectRepository',
            $this->get('elcodi.repository.product')
        );
    }

    /**
     * Test when getting products from a category with not empty subcategories.
     */
    public function testGettingProductsFromOneCategoryWithSubcategories()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'root-category']);

        $products = $this
            ->productRepository
            ->getAllFromCategories([$rootCategory]);

        $this->assertCount(
            1,
            $products,
            'It should only return one product on the root category'
        );

        $product = $products[0];

        $this->assertEquals(
            $product->getName(),
            'Root category product',
            'The product expected was the one on the root category'
        );
    }

    /**
     * Test when getting products from multiple categories.
     */
    public function testGettingProductsFromMultipleCategories()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'root-category']);

        $category = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'category']);

        $products = $this
            ->productRepository
            ->getAllFromCategories(
                [
                    $rootCategory,
                    $category,
                ]
            );

        $this->assertCount(
            3,
            $products,
            'It should only return one product on the root category'
        );
    }

    /**
     * Test get home products.
     *
     * @dataProvider dataGetHomeProducts
     */
    public function testGetHomeProducts($count, $numberExpected, $useStock)
    {
        $product = $this->find('product', 2);
        $oldStock = $product->getStock();
        $product->setStock(0);
        $this->flush($product);

        $products = $this
            ->productRepository
            ->getHomeProducts($count, $useStock);

        $this->assertTrue(is_array($products));
        $this->assertCount($numberExpected, $products);

        $product->setStock($oldStock);
        $this->flush($product);
    }

    /**
     * Count values for testGetHomeProducts.
     */
    public function dataGetHomeProducts()
    {
        return [
            [0, 4, false],
            [1, 1, false],
            [2, 2, false],
            [3, 3, false],
            [4, 4, false],
            [5, 4, false],
            [0, 3, true],
            [3, 3, true],
            [4, 3, true],
        ];
    }

    /**
     * Test get home products.
     *
     * @dataProvider dataGetOfferProducts
     */
    public function testGetOfferProducts($count, $numberExpected, $useStock)
    {
        $product = $this->find('product', 2);
        $oldStock = $product->getStock();
        $product->setStock(0);
        $this->flush($product);

        $products = $this
            ->productRepository
            ->getOfferProducts($count, $useStock);

        $this->assertTrue(is_array($products));
        $this->assertCount($numberExpected, $products);

        $product->setStock($oldStock);
        $this->flush($product);
    }

    /**
     * Count values for testGetOfferProducts.
     */
    public function dataGetOfferProducts()
    {
        return [
            [0, 1, false],
            [1, 1, false],
            [2, 1, false],
            [0, 0, true],
            [1, 0, true],
            [2, 0, true],
        ];
    }
}
