<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Shipping\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;

/**
 * Class ShippingRangeFactory
 */
class ShippingRangeFactory extends AbstractFactory
{
    /**
     * @var WrapperInterface
     *
     * Currency wrapper used to access default Currency object
     */
    protected $defaultCurrencyWrapper;

    /**
     * Factory constructor
     *
     * @param WrapperInterface $defaultCurrencyWrapper Default Currency wrapper
     */
    public function __construct(WrapperInterface $defaultCurrencyWrapper)
    {
        $this->defaultCurrencyWrapper = $defaultCurrencyWrapper;
    }

    /**
     * Returns a zero-initialized Money object
     * to be assigned to product prices
     *
     * @return MoneyInterface
     */
    protected function createZeroAmountMoney()
    {
        return Money::create(
            0,
            $this
                ->defaultCurrencyWrapper
                ->get()
        );
    }

    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return ShippingRangeInterface Empty entity
     */
    public function create()
    {
        /**
         * @var ShippingRangeInterface $shippingPriceRange
         */
        $classNamespace = $this->getEntityNamespace();
        $shippingPriceRange = new $classNamespace();

        $shippingPriceRange
            ->setPrice($this->createZeroAmountMoney())
            ->setToPrice($this->createZeroAmountMoney())
            ->setFromPrice($this->createZeroAmountMoney())
            ->setEnabled(true);

        return $shippingPriceRange;
    }
}
