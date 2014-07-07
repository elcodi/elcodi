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

namespace Elcodi\VariantBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\AttributeBundle\Entity\Value;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ManufacturerInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;

class VariantData extends AbstractFixture
{
    /**
     * Loads sample fixtures for product Variant entities
     *
     * @param ObjectManager $objectManager
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
        $product = $this->container->get('elcodi.core.variant.factory.product')->create();
        $category = $this->getReference('category');
        $manufacturer = $this->getReference('manufacturer');
        $currency = $this->getReference('currency-dollar');
        $product
            ->setName('Product with variants')
            ->setSku('product-sku-code-variant-1')
            ->setSlug('product-with-variants')
            ->setDescription('my product with variants description')
            ->setShortDescription('my product with variants short description')
            ->addCategory($category)
            ->setPrincipalCategory($category)
            ->setManufacturer($manufacturer)
            ->setStock(10)
            ->setPrice(new Money(1000, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $manager->flush($product);

        $this->addReference('product-with-variant', $product);

        /* Variants */

        /**
         * @var $optionWhite Value
         * @var $optionRed Value
         * @var $optionSmall Value
         * @var $optionLarge Value
         */
        $optionWhite = $this->getReference('value-color-white');
        $optionRed = $this->getReference('value-color-red');
        $optionSmall = $this->getReference('value-size-small');
        $optionLarge = $this->getReference('value-size-large');

        /* Variant White-Small */
        $variantWhiteSmall = $this->container->get('elcodi.core.variant.factory.variant')->create();
        $variantWhiteSmall
            ->setSku('variant-white-small-sku')
            ->setStock(100)
            ->setProduct($product)
            ->addOption($optionWhite)
            ->addOption($optionSmall)
            ->setPrice(Money::create(1500, $currency))
            ->setEnabled(true);

        $product->setPrincipalVariant($variantWhiteSmall);

        $manager->persist($variantWhiteSmall);
        $this->addReference('variant-white-small', $product);

        /* Variant White-Large */
        $variantWhiteLarge = $this->container->get('elcodi.core.variant.factory.variant')->create();
        $variantWhiteLarge
            ->setSku('variant-white-large-sku')
            ->setStock(100)
            ->setProduct($product)
            ->addOption($optionWhite)
            ->addOption($optionLarge)
            ->setPrice(Money::create(1800, $currency))
            ->setEnabled(true);

        $manager->persist($variantWhiteLarge);
        $this->addReference('variant-white-large', $product);

        /* Variant Red-Small */
        $variantRedSmall = $this->container->get('elcodi.core.variant.factory.variant')->create();
        $variantRedSmall
            ->setSku('variant-red-small-sku')
            ->setStock(100)
            ->setProduct($product)
            ->addOption($optionRed)
            ->addOption($optionSmall)
            ->setPrice(Money::create(1500, $currency))
            ->setEnabled(true);

        $manager->persist($variantRedSmall);
        $this->addReference('variant-red-small', $product);

        /* Variant Red-Large */
        $variantRedLarge = $this->container->get('elcodi.core.variant.factory.variant')->create();
        $variantRedLarge
            ->setSku('variant-red-large-sku')
            ->setStock(100)
            ->setProduct($product)
            ->addOption($optionRed)
            ->addOption($optionLarge)
            ->setPrice(Money::create(1800, $currency))
            ->setEnabled(true);

        $manager->persist($variantRedLarge);
        $this->addReference('variant-red-large', $product);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
