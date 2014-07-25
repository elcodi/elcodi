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

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ManufacturerInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ProductData
 */
class ProductData extends AbstractFixture
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
        $product = $this->container->get('elcodi.core.product.factory.product')->create();
        $category = $this->getReference('category');
        $manufacturer = $this->getReference('manufacturer');
        $currency = $this->getReference('currency-dollar');
        $product
            ->setName('product')
            ->setSku('product-sku-code-1')
            ->setSlug('product')
            ->setDescription('my product description')
            ->setShortDescription('my product short description')
            ->addCategory($category)
            ->setPrincipalCategory($category)
            ->setManufacturer($manufacturer)
            ->setStock(10)
            ->setPrice(Money::create(1000, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product', $product);

        /**
         * Reduced Product
         *
         * @var ProductInterface $productReduced
         */
        $productReduced = $this->container->get('elcodi.core.product.factory.product')->create();
        $productReduced
            ->setName('product-reduced')
            ->setSlug('product-reduced')
            ->setDescription('my product-reduced description')
            ->setShortDescription('my product-reduced short description')
            ->setStock(5)
            ->setPrice(Money::create(1000, $currency))
            ->setReducedPrice(Money::create(500, $currency))
            ->setEnabled(true);

        $manager->persist($productReduced);
        $this->addReference('product-reduced', $productReduced);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
