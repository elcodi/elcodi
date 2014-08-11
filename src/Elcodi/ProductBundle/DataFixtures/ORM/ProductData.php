<?php

/**
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

namespace Elcodi\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ManufacturerInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;

/**
 * Class ProductData
 */
class ProductData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Product
         *
         * @var ProductInterface      $product
         * @var CategoryInterface     $category
         * @var ManufacturerInterface $manufacturer
         * @var CurrencyInterface     $currency
         */
        $product = $this
            ->container
            ->get('elcodi.core.product.factory.product')
            ->create();

        $category = $this->getReference('category');
        $manufacturer = $this->getReference('manufacturer');
        $currency = $this->getReference('currency-dollar');
        $product
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
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product', $product);

        /**
         * Reduced Product
         *
         * @var ProductInterface $productReduced
         */
        $productReduced = $this
            ->container
            ->get('elcodi.core.product.factory.product')
            ->create();

        $productReduced
            ->setName('product-reduced')
            ->setSlug('product-reduced')
            ->setDescription('my product-reduced description')
            ->setShortDescription('my product-reduced short description')
            ->setShowInHome(true)
            ->setStock(5)
            ->setPrice(Money::create(1000, $currency))
            ->setReducedPrice(Money::create(500, $currency))
            ->setEnabled(true);

        $manager->persist($productReduced);
        $this->addReference('product-reduced', $productReduced);

        /**
         * Product with variants
         *
         * @var ProductInterface $productReduced
         */
        $productWithVariants = $this
            ->container
            ->get('elcodi.core.product.factory.product')
            ->create();

        $productWithVariants
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
            ->setEnabled(true);

        $manager->persist($productWithVariants);

        $this->addReference('product-with-variants', $productWithVariants);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\CurrencyBundle\DataFixtures\ORM\CurrencyData',
            'Elcodi\ProductBundle\DataFixtures\ORM\CategoryData',
            'Elcodi\ProductBundle\DataFixtures\ORM\ManufacturerData',
        ];
    }
}
