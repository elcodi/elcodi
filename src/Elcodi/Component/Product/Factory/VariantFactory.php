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

namespace Elcodi\Component\Product\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Currency\Factory\Abstracts\AbstractPurchasableFactory;
use Elcodi\Component\Product\Entity\Variant;

/**
 * Factory for Variant entities.
 */
class VariantFactory extends AbstractPurchasableFactory
{
    /**
     * Creates and returns a pristine Variant instance.
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
            ->setSku('')
            ->setStock(0)
            ->setPrice($zeroPrice)
            ->setReducedPrice($zeroPrice)
            ->setImages(new ArrayCollection())
            ->setOptions(new ArrayCollection())
            ->setWidth(0)
            ->setHeight(0)
            ->setWidth(0)
            ->setDepth(0)
            ->setWeight(0)
            ->setShowInHome(false)
            ->setImagesSort('')
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $variant;
    }
}
