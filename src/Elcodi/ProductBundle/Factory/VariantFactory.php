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

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper;
use Elcodi\ProductBundle\Entity\Variant;

/**
 * Factory for Variant entities
 */
class VariantFactory extends AbstractFactory
{
    /**
     * @var CurrencyWrapper
     */
    protected $currencyWrapper;

    /**
     * @param CurrencyWrapper $currencyWrapper
     */
    public function __construct(CurrencyWrapper $currencyWrapper)
    {
        $this->currencyWrapper = $currencyWrapper;
    }

    /**
     * Creates a Variant instance
     *
     * @return Variant New Attribute entity
     */
    public function create()
    {
        $currency = $this->currencyWrapper->getDefaultCurrency();
        $zeroPrice = Money::create(0, $currency);

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
