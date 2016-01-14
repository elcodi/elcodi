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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\EventListener;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryRepositoryTest.
 */
class RootCategoryEventListenerTest extends WebTestCase
{
    /**
     * @var ObjectDirector
     *
     * The category director.
     */
    protected $categoryDirector;

    /**
     * Setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->categoryDirector = $this->get('elcodi.director.category');
    }

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
     * Test that creating a new root category the parent category should be null.
     */
    public function testNewRootCategoryIsSavedWithoutParent()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryDirector
            ->findOneBy(['slug' => 'root-category']);

        $category = $this->categoryDirector->create();
        $category->setRoot(true);
        $category->setParent($rootCategory);
        $category->setName('New root category');
        $category->setSlug('new-root-category');

        $this
            ->categoryDirector
            ->save($category);

        /**
         * @var $category CategoryInterface
         */
        $category = $this
            ->categoryDirector
            ->findOneBy(['slug' => 'new-root-category']);

        $this->assertNull(
            $category->getParent(),
            'The parent for a root category should always be null'
        );
    }

    /**
     * Test that modifying a new root category the parent category should be
     * null.
     */
    public function testEditRootCategoryIsSavedWithoutParent()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryDirector
            ->findOneBy(['slug' => 'root-category']);

        /**
         * @var $anotherCategory CategoryInterface
         */
        $anotherCategory = $this
            ->categoryDirector
            ->findOneBy(['slug' => 'category']);

        $rootCategory->setParent($anotherCategory);

        $this
            ->categoryDirector
            ->save($rootCategory);

        /**
         * @var $category CategoryInterface
         */
        $category = $this
            ->categoryDirector
            ->findOneBy(['slug' => 'root-category']);

        $this->assertNull(
            $category->getParent(),
            'The parent for a root category should always be null'
        );
    }
}
