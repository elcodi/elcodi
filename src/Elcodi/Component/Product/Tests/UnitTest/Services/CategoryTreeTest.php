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

namespace Elcodi\Component\Product\Tests\UnitTest\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\Entity\Category;
use Elcodi\Component\Product\Repository\CategoryRepository;
use Elcodi\Component\Product\Services\CategoryTree;

/**
 * Class CategoryTreeTest.
 */
class CategoryTreeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testBuildCategory.
     *
     * @return array
     */
    public function buildCategoryProvider()
    {
        return [
            'No categories' => [
                [],
                [],
            ],
            'Only parent categories' => [
                [
                    $this->getCategoryEntity(1, true, null),
                    $this->getCategoryEntity(2, true, null),
                ],
                [
                    [
                        'entity' => $this->getCategoryEntity(1, true, null),
                        'children' => [],
                    ],
                    [
                        'entity' => $this->getCategoryEntity(2, true, null),
                        'children' => [],
                    ],
                ],
            ],
            'Parent and children categories' => [
                [
                    $this->getCategoryEntity(1, true, null),
                    $this->getCategoryEntity(2, true, null),
                    $this->getCategoryEntity(3, true, null),
                    $this->getCategoryEntity(4, false, $this->getCategoryEntity(1, false, null)),
                    $this->getCategoryEntity(5, false, $this->getCategoryEntity(1, false, null)),
                    $this->getCategoryEntity(6, false, $this->getCategoryEntity(2, false, null)),
                ],
                [
                    [
                        'entity' => $this->getCategoryEntity(1, true, null),
                        'children' => [
                            [
                                'entity' => $this->getCategoryEntity(
                                    4,
                                    false,
                                    $this->getCategoryEntity(1, false, null)
                                ),
                                'children' => [],
                            ],
                            [
                                'entity' => $this->getCategoryEntity(
                                    5,
                                    false,
                                    $this->getCategoryEntity(1, false, null)
                                ),
                                'children' => [],
                            ],
                        ],
                    ],
                    [
                        'entity' => $this->getCategoryEntity(2, true, null),
                        'children' => [
                            [
                                'entity' => $this->getCategoryEntity(
                                    6,
                                    false,
                                    $this->getCategoryEntity(2, false, null)
                                ),
                                'children' => [],
                            ],
                        ],
                    ],
                    [
                        'entity' => $this->getCategoryEntity(3, true, null),
                        'children' => [],
                    ],
                ],
            ],
        ];
    }

    /**
     * Tests that the tree builder is working fine.
     *
     * @dataProvider buildCategoryProvider
     *
     * @param array $allRepositoryCategories All the categories returned by the repo
     * @param array $expectedCategoryTree    The expected category tree
     */
    public function testBuildCategory($allRepositoryCategories, $expectedCategoryTree)
    {
        $mockCategoryRepository = $this->buildCategoryRepositoryMock($allRepositoryCategories);
        $categoryTreeClass = $this->buildCategoryTreeClass($mockCategoryRepository);
        $categoryTreeResponse = $categoryTreeClass->buildCategoryTree();

        $message = 'The received response does not match with the expected one';

        $this->assertEquals(
            $categoryTreeResponse,
            $expectedCategoryTree,
            $message
        );
    }

    /**
     * Builds a Category repository mock.
     *
     * @param array $allCategoriesSortedResponse All the categories that the repository returns
     *
     * @return CategoryRepository The mocked category repository.
     */
    protected function buildCategoryRepositoryMock(array $allCategoriesSortedResponse)
    {
        /**
         * All this params are set to avoid original constructor to be called.
         */
        $categoryRepositoryMock = $this->getMock(
            'Elcodi\Component\Product\Repository\CategoryRepository',
            [],
            [],
            '',
            false
        );
        $categoryRepositoryMock
            ->expects($this->once())
            ->method('getAllCategoriesSortedByParentAndPositionAsc')
            ->will($this->returnValue($allCategoriesSortedResponse));

        return $categoryRepositoryMock;
    }

    /**
     * Builds a new category tree class for test purposes.
     *
     * @param CategoryRepository $mockedCategoryRepository A mocked category repository
     *
     * @return CategoryTree The category tree class.
     */
    protected function buildCategoryTreeClass($mockedCategoryRepository)
    {
        return new CategoryTree($mockedCategoryRepository);
    }

    /**
     * Gets a new category entity class.
     *
     * @param int           $id             The id to set to the entity.
     * @param bool          $isRoot         If the category is a root category.
     * @param Category|null $parentCategory The category to set as parent
     *
     * @return Category
     */
    public function getCategoryEntity($id, $isRoot, $parentCategory)
    {
        $category = new Category();
        $category->setId($id);
        $category->setRoot($isRoot);
        $category->setParent($parentCategory);

        return $category;
    }
}
