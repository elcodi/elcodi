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

namespace Elcodi\Component\Product\Tests\UnitTest\Services;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\Entity\Category;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Product;
use Elcodi\Component\Product\Services\CategoryIntegrityFixer;

/**
 * Class CategoryIntegrityFixerTest
 */
class CategoryIntegrityFixerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CategoryIntegrityFixer
     *
     * A category Integrity fixer
     */
    protected static $categoryIntegrityFixer;

    /**
     * This method is only executed the first time.
     */
    public static function setUpBeforeClass()
    {
        self::$categoryIntegrityFixer = new CategoryIntegrityFixer();
    }

    /**
     * Test that the principal category is assigned as category when a product
     * only has principal category.
     */
    public function testFixProductWhenPrincipalCategoryNotAssigned()
    {
        $product = $this->getNewProduct(1);
        $category = $this->getNewCategory(1);
        $product->setPrincipalCategory($category);

        self::$categoryIntegrityFixer
            ->fixProduct($product);

        $categories = $product->getCategories();

        $this->assertEquals(
            1,
            $categories->count(),
            'Only one category is expected to be assigned to the product'
        );

        $this->assertEquals(
            1,
            $categories->first()->getId(),
            'The category assigned to the product is not the principal category'
        );
    }

    /**
     * Test that the principal category is assigned when a product has
     * categories but not principal category.
     */
    public function testFixProductWhenNoPrincipalCategoryButCategories()
    {
        $product = $this->getNewProduct(1);
        $category = $this->getNewCategory(1);
        $product->addCategory($category);

        self::$categoryIntegrityFixer
            ->fixProduct($product);

        $principalCategory = $product->getPrincipalCategory();

        $this->assertInstanceOf(
            get_class($category),
            $principalCategory,
            'The principal category should be assigned'
        );

        $this->assertEquals(
            1,
            $principalCategory->getId(),
            'The category assigned as principal category is not the one expected'
        );
    }

    /**
     * Gets a new category
     *
     * @param integer $id It's id
     *
     * @return CategoryInterface
     */
    public function getNewCategory($id)
    {
        $category = new Category();
        $category->setId($id);

        return $category;
    }

    /**
     * Gets a new product
     *
     * @param integer $id The product id.
     *
     * @return Product
     */
    public function getNewProduct($id)
    {
        $product = new Product();
        $product->setId($id);
        $product->setCategories(new ArrayCollection());

        return $product;
    }
}
