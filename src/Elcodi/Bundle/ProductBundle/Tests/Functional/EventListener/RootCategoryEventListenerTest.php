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

use Doctrine\ORM\EntityManager;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Factory\CategoryFactory;
use Elcodi\Component\Product\Repository\CategoryRepository;

/**
 * Class CategoryRepositoryTest
 */
class RootCategoryEventListenerTest extends WebTestCase
{
    /**
     * @var CategoryRepository
     *
     * LocationProvider class
     */
    protected $categoryRepository;

    /**
     * @var CategoryFactory
     *
     * Category factory class
     */
    protected $categoryFactory;

    /**
     * @var EntityManager
     *
     * Category entity manager
     */
    protected $entityManager;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        $this->categoryRepository = $this->get('elcodi.repository.category');
        $this->categoryFactory = $this->get('elcodi.factory.category');
        $this->entityManager = $this->get('elcodi.object_manager.category');
    }

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
        return [
            'ElcodiProductBundle',
        ];
    }

    /**
     * Test that creating a new root category the parent category should be null
     */
    public function testNewRootCategoryIsSavedWithoutParent()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'root-category']);

        $category = $this->categoryFactory->create();
        $category->setRoot(true);
        $category->setParent($rootCategory);
        $category->setName('New root category');
        $category->setSlug('new-root-category');

        $this
            ->entityManager
            ->persist($category);
        $this
            ->entityManager
            ->flush($category);

        /**
         * @var $category CategoryInterface
         */
        $category = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'new-root-category']);

        $this->assertNull(
            $category->getParent(),
            'The parent for a root category should always be null'
        );
    }

    /**
     * Test that modifying a new root category the parent category should be
     * null
     */
    public function testEditRootCategoryIsSavedWithoutParent()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'root-category']);

        /**
         * @var $anotherCategory CategoryInterface
         */
        $anotherCategory = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'category']);

        $rootCategory->setParent($anotherCategory);

        $this
            ->entityManager
            ->flush($rootCategory);

        /**
         * @var $category CategoryInterface
         */
        $category = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'root-category']);

        $this->assertNull(
            $category->getParent(),
            'The parent for a root category should always be null'
        );
    }
}
