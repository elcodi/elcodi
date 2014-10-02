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

namespace Elcodi\Component\Product\Factory;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Product\ElcodiProductTypes;
use Elcodi\Component\Product\Entity\Product;
use Elcodi\Component\Product\Factory\Abstracts\AbstractPurchasableFactory;

/**
 * Factory for Product entities
 */
class ProductFactory extends AbstractPurchasableFactory
{
    /**
     * Creates and returns a pristine Product instance
     *
     * Prices are initialized to "zero amount" Money value objects,
     * using injected CurrencyWrapper default Currency
     *
     * @return Product New Product entity
     */
    public function create()
    {
        $zeroPrice = $this->createZeroAmountMoney();

        /**
         * @var Product $product
         */
        $classNamespace = $this->getEntityNamespace();
        $product = new $classNamespace();
        $product
            ->setStock(0)
            ->setType(ElcodiProductTypes::TYPE_PRODUCT_PHYSICAL)
            ->setShowInHome(false)
            ->setPrice($zeroPrice)
            ->setReducedPrice($zeroPrice)
            ->setAttributes(new ArrayCollection())
            ->setVariants(new ArrayCollection())
            ->setCategories(new ArrayCollection)
            ->setImages(new ArrayCollection())
            ->setWidth(0)
            ->setHeight(0)
            ->setWidth(0)
            ->setWeight(0)
            ->setEnabled(false)
            ->setCreatedAt(new DateTime);

        return $product;
    }
}
