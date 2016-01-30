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
use Elcodi\Component\Product\Repository\PurchasableRepository;

/**
 * Class PurchasableRepositoryTest.
 */
class PurchasableRepositoryTest extends WebTestCase
{
    /**
     * @var CategoryRepository
     *
     * LocationProvider class
     */
    protected $categoryRepository;

    /**
     * @var PurchasableRepository
     *
     * LocationProvider class
     */
    protected $purchasableRepository;

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

        $this->purchasableRepository = $this->get('elcodi.repository.purchasable');
        $this->categoryRepository = $this->get('elcodi.repository.category');
    }

    /**
     * Test purchasable repository provider.
     */
    public function testRepositoryProvider()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\ObjectRepository',
            $this->get('elcodi.repository.purchasable')
        );
    }

    /**
     * Test when getting purchasables from a category with not empty subcategories.
     */
    public function testGettingPurchasablesFromOneCategoryWithSubcategories()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'root-category']);

        $purchasables = $this
            ->purchasableRepository
            ->getAllFromCategories([$rootCategory]);

        $this->assertCount(
            1,
            $purchasables,
            'It should only return one purchasable on the root category'
        );

        $purchasable = $purchasables[0];

        $this->assertEquals(
            $purchasable->getName(),
            'Root category product',
            'The purchasable expected was the one on the root category'
        );
    }

    /**
     * Test when getting purchasables from multiple categories.
     */
    public function testGettingPurchasablesFromMultipleCategories()
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

        $purchasables = $this
            ->purchasableRepository
            ->getAllFromCategories(
                [
                    $rootCategory,
                    $category,
                ]
            );

        $this->assertCount(
            5,
            $purchasables
        );
    }

    /**
     * Test get home purchasables.
     *
     * @dataProvider dataGetHomePurchasables
     */
    public function testGetHomePurchasables($count, $numberExpected, $useStock)
    {
        $purchasable = $this->find('purchasable', 2);
        $oldStock = $purchasable->getStock();
        $purchasable->setStock(0);
        $this->flush($purchasable);

        $purchasables = $this
            ->purchasableRepository
            ->getHomePurchasables($count, $useStock);

        $this->assertTrue(is_array($purchasables));
        $this->assertCount($numberExpected, $purchasables);

        $purchasable->setStock($oldStock);
        $this->flush($purchasable);
    }

    /**
     * Count values for testGetHomePurchasables.
     */
    public function dataGetHomePurchasables()
    {
        return [
            [0, 6, false],
            [1, 1, false],
            [2, 2, false],
            [3, 3, false],
            [6, 6, false],
            [7, 6, false],
            [0, 4, true],
            [4, 4, true],
            [5, 4, true],
        ];
    }

    /**
     * Test get home purchasables.
     *
     * @dataProvider dataGetOfferPurchasables
     */
    public function testGetOfferPurchasables($count, $numberExpected, $useStock)
    {
        $purchasable = $this->find('purchasable', 2);
        $oldStock = $purchasable->getStock();
        $purchasable->setStock(0);
        $this->flush($purchasable);

        $purchasables = $this
            ->purchasableRepository
            ->getOfferPurchasables($count, $useStock);

        $this->assertTrue(is_array($purchasables));
        $this->assertCount($numberExpected, $purchasables);

        $purchasable->setStock($oldStock);
        $this->flush($purchasable);
    }

    /**
     * Count values for testGetOfferPurchasables.
     */
    public function dataGetOfferPurchasables()
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
