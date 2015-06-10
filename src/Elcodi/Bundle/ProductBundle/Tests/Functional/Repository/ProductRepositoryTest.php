<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
use Elcodi\Component\Product\Repository\ProductRepository;

/**
 * Class ProductRepositoryTest
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
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.repository.product',
        ];
    }

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
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        $this->productRepository = $this->get('elcodi.repository.product');
        $this->categoryRepository = $this->get('elcodi.repository.category');
    }

    /**
     * Test product repository provider
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
}
