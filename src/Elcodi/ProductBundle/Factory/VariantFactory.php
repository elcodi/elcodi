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

namespace Elcodi\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\ProductBundle\Entity\Variant;
use Elcodi\ProductBundle\Factory\Abstracts\AbstractPurchasableFactory;

/**
 * Factory for Variant entities
 */
class VariantFactory extends AbstractPurchasableFactory
{
    /**
     * Creates and returns a pristine Variant instance
     *
     * Prices are initialized to "zero amount" Money value objects,
     * using injected CurrencyWrapper default Currency
     *
     * @return Variant New Variant entity
     */
    public function create()
    {
        $zeroPrice = $this->createZeroAmountMoney();

        /**
         * @var Variant $variant
         */
        $classNamespace = $this->getEntityNamespace();
        $variant = new $classNamespace();
        $variant
            ->setSku("")
            ->setStock(0)
            ->setPrice($zeroPrice)
            ->setReducedPrice($zeroPrice)
            ->setOptions(new ArrayCollection())
            ->setEnabled(false)
            ->setCreatedAt(new \DateTime);

        return $variant;
    }
}
