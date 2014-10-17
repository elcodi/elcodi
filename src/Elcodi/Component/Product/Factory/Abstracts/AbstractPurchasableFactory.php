<?php

/*
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

namespace Elcodi\Component\Product\Factory\Abstracts;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

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
    protected $currencyWrapper;

    /**
     * Factory constructor
     *
     * @param CurrencyWrapper $currencyWrapper Currency wrapper
     */
    public function __construct(CurrencyWrapper $currencyWrapper)
    {
        $this->currencyWrapper = $currencyWrapper;
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
            $this->currencyWrapper->getDefaultCurrency()
        );
    }
}
