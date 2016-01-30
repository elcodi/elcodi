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

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Bundle\ProductBundle\DataFixtures\ORM\Traits\ProductWithImagesTrait;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class ProductData.
 */
class ProductData extends AbstractFixture implements DependentFixtureInterface
{
    use ProductWithImagesTrait;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Product.
         *
         * @var CategoryInterface     $category
         * @var ManufacturerInterface $manufacturer
         * @var CurrencyInterface     $currency
         * @var ObjectDirector        $productDirector
         */
        $category = $this->getReference('category');
        $rootCategory = $this->getReference('rootCategory');
        $manufacturer = $this->getReference('manufacturer');
        $currency = $this->getReference('currency-dollar');
        $productDirector = $this->getDirector('product');

        $product = $productDirector
            ->create()
            ->setName('product')
            ->setSlug('product')
            ->setDescription('my product description')
            ->setShortDescription('my product short description')
            ->addCategory($category)
            ->setPrincipalCategory($category)
            ->setManufacturer($manufacturer)
            ->setStock(10)
            ->setPrice(Money::create(1000, $currency))
            ->setSku('product-sku-code-1')
            ->setHeight(10)
            ->setWidth(15)
            ->setDepth(20)
            ->setWeight(100)
            ->setEnabled(true);

        $productDirector->save($product);
        $this->addReference('product', $product);

        /**
         * Reduced Product.
         */
        $productReduced = $productDirector
            ->create()
            ->setName('product-reduced')
            ->setSlug('product-reduced')
            ->setDescription('my product-reduced description')
            ->setShortDescription('my product-reduced short description')
            ->setShowInHome(true)
            ->setStock(5)
            ->setPrice(Money::create(1000, $currency))
            ->setReducedPrice(Money::create(500, $currency))
            ->setHeight(25)
            ->setWidth(30)
            ->setDepth(35)
            ->setWeight(200)
            ->setEnabled(true);

        $this->storeProductImage(
            $productReduced,
            'product.jpg'
        );

        $productDirector->save($productReduced);
        $this->addReference('product-reduced', $productReduced);

        /**
         * Product with variants.
         *
         * @var ProductInterface $productWithVariants
         */
        $productWithVariants = $productDirector
            ->create()
            ->setName('Product with variants')
            ->setSku('product-sku-code-variant-1')
            ->setSlug('product-with-variants')
            ->setDescription('my product with variants description')
            ->setShortDescription('my product with variants short description')
            ->addCategory($category)
            ->setPrincipalCategory($category)
            ->setManufacturer($manufacturer)
            ->setStock(10)
            ->setPrice(Money::create(1000, $currency))
            ->setHeight(40)
            ->setWidth(45)
            ->setDepth(50)
            ->setWeight(500)
            ->setEnabled(true);

        $productDirector->save($productWithVariants);
        $this->addReference('product-with-variants', $productWithVariants);

        /**
         * Root category product.
         *
         * @var ProductInterface $rootCategoryProduct
         */
        $rootCategoryProduct = $productDirector
            ->create()
            ->setName('Root category product')
            ->setSlug('root-category-product')
            ->setDescription('my product description')
            ->setShortDescription('my product short description')
            ->addCategory($rootCategory)
            ->setPrincipalCategory($rootCategory)
            ->setManufacturer($manufacturer)
            ->setStock(10)
            ->setPrice(Money::create(500, $currency))
            ->setSku('product-sku-code-3')
            ->setHeight(10)
            ->setWidth(15)
            ->setDepth(20)
            ->setWeight(100)
            ->setEnabled(true);

        $productDirector->save($rootCategoryProduct);
        $this->addReference('rootCategoryProduct', $rootCategoryProduct);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\CategoryData',
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ManufacturerData',
            'Elcodi\Bundle\StoreBundle\DataFixtures\ORM\StoreData',
        ];
    }
}
