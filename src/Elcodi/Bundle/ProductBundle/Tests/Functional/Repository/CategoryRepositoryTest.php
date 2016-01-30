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

/**
 * Class CategoryRepositoryTest.
 */
class CategoryRepositoryTest extends WebTestCase
{
    /**
     * @var CategoryRepository
     *
     * LocationProvider class
     */
    protected $categoryRepository;

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

        $this->categoryRepository = $this->get('elcodi.repository.category');
    }

    /**
     * Test category repository provider.
     */
    public function testRepositoryProvider()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\ObjectRepository',
            $this->get('elcodi.repository.category')
        );
    }

    /**
     * Test the repository to check that the get children categories returns
     * only the first level children categories (Not recursive).
     */
    public function testGetChildrenCategoriesNotRecursively()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'root-category']);

        $childrenCategories = $this->categoryRepository->getChildrenCategories(
            $rootCategory
        );

        $this->assertCount(
            1,
            $childrenCategories,
            'It should only return one category on non recursive mode'
        );
    }

    /**
     * Test the repository to check that the get children categories returns
     * all the children categories (Recursively).
     */
    public function testGetChildrenCategoriesRecursively()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'root-category']);

        $childrenCategories = $this->categoryRepository->getChildrenCategories(
            $rootCategory,
            true
        );

        $this->assertCount(
            2,
            $childrenCategories,
            'It should only return two categories on recursive mode'
        );
    }
}
