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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Product\Services\CategoryManager;

/**
 * Tests CategoryManager class
 */
class CategoryManagerTest extends WebTestCase
{
    /**
     * @var CategoryManager
     *
     * Category manager
     */
    protected $categoryManager;

    /**
     * @var array
     *
     * Category tree
     */
    protected $categoryTree = [
        0 => [
            'entity'   => [
                'id'            => 1,
                'name'          => 'root-category',
                'slug'          => 'root-category',
                'productsCount' => 0
            ],
            'children' => [
                0 => [
                    'entity'   => [
                        'id'            => 2,
                        'name'          => 'category',
                        'slug'          => 'category',
                        'productsCount' => 0
                    ],
                    'children' => []
                ]
            ]
        ]
    ];

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
            'elcodi.core.product.service.category_manager',
            'elcodi.category_manager',
        ];
    }

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        $this->categoryManager = $this->get('elcodi.category_manager');
    }

    /**
     * Test category load from database
     */
    public function testCategoryTreeNullWithoutLoad()
    {
        $this->assertNull($this->categoryManager->getCategoryTree());
    }

    /**
     * Test category load from database
     */
    public function testCategoryTreeLoad()
    {
        $categoryTree = $this->categoryManager->load();
        $this->assertSame($categoryTree, $this->categoryManager->getCategoryTree());
        $this->assertEquals($categoryTree, $this->categoryTree);
    }

    /**
     * Test category loaded from cache
     *
     * We will just modify the database once categorytree is loaded
     */
    public function testCategoryTreeLoadFromCache()
    {
        $categoryTree = $this->categoryManager->load();
        $category = $this->find('category', 1);
        $category->setEnabled(false);
        $this->flush($category);

        $reloadedCategoryTree = $this->categoryManager->load();
        $this->assertEquals($categoryTree, $reloadedCategoryTree);
    }

    /**
     * Test category loaded from cache
     *
     * We will just modify the database once categorytree is loaded
     *
     * @dataProvider dataCategoryTreeLoadFromCacheAndReloaded
     */
    public function testCategoryTreeLoadFromCacheAndReloaded($categoryDisabled, $result)
    {
        $this->categoryManager->load();
        $category = $this->find('category', $categoryDisabled);
        $category->setEnabled(false);
        $this->flush($category);

        $reloadedCategoryTree = $this->categoryManager->reload();
        $this->assertEquals($result, $reloadedCategoryTree);
    }

    /**
     * data for testCategoryTreeLoadFromCacheAndReloaded
     *
     * @return array Data
     */
    public function dataCategoryTreeLoadFromCacheAndReloaded()
    {
        return [
            [1, []],
            [2, [
                0 => [
                    'entity'   => [
                        'id'            => 1,
                        'name'          => 'root-category',
                        'slug'          => 'root-category',
                        'productsCount' => 0
                    ],
                    'children' => []
                ]
            ]]
        ];
    }
}
