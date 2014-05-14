<?php

/**
 * This file is part of BeEcommerce.
 *
 * @author Befactory Team
 * @since 2013
 */

namespace Elcodi\ProductBundle\DataFixtures\ORM;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
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
         * @var ProductInterface $product
         * @var CategoryInterface $category
         * @var ManufacturerInterface $manufacturer
         */
        $product = $this->container->get('elcodi.core.product.factory.product')->create();
        $category = $this->getReference('category');
        $manufacturer = $this->getReference('manufacturer');
        $product
            ->setName('product')
            ->setSlug('product')
            ->setDescription('my product description')
            ->setShortDescription('my product short description')
            ->addCategory($category)
            ->setPrincipalCategory($category)
            ->setManufacturer($manufacturer)
            ->setStock(10)
            ->setPrice(10);

        $manager->persist($product);
        $this->addReference('product', $product);

        /**
         * Reduced Product
         *
         * @var ProductInterface $product
         */
        $productReduced = $this->container->get('elcodi.core.product.factory.product')->create();
        $productReduced
            ->setName('product-reduced')
            ->setSlug('product-reduced')
            ->setDescription('my product-reduced description')
            ->setShortDescription('my product-reduced short description')
            ->setStock(5)
            ->setPrice(10)
            ->setReducedPrice(5);

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
