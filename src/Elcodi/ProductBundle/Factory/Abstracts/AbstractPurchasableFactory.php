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

namespace Elcodi\ProductBundle\Factory\Abstracts;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper;

/**
 * Class AbstractPurchasableFactory
 *
 * Abstract factory for purchasable entities that need
 * a default currency to be properly initialized
 */
abstract class AbstractPurchasableFactory extends AbstractFactory
{
    /**
     * @var CurrencyWrapper
     *
     * Currency wrapper used to access default Currency object
     */
    protected $defaultCurrency;

    /**
     * Factory constructor
     *
     * @param CurrencyInterface $currency default Currency
     */
    public function __construct(CurrencyInterface $currency)
    {
        $this->defaultCurrency = $currency;
    }

    /**
     * Returns a zero-initialized Money object
     * to be assigned to product prices
     *
     * @return MoneyInterface
     */
    protected function createZeroAmountMoney()
    {
        return Money::create(0, $this->defaultCurrency);
    }
}
