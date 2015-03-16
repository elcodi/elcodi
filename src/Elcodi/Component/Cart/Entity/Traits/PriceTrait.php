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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Cart\Entity\Traits;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Trait for entities that hold prices.
 *
 * CartLine and OrderLine entities usually will have this trait.
 *
 * A currency is needed so that a {@see Money} value object can be
 * exploited when doing currency arithmetics. When Currency is not
 * set, it is not possible to return a Money object, so getters
 * wil return null
 */
trait PriceTrait
{
    /**
     * @var integer
     *
     * Product amount
     */
    protected $productAmount;

    /**
     * @var CurrencyInterface
     *
     * Currency for the amounts stored in this entity
     */
    protected $productCurrency;

    /**
     * @var integer
     *
     * Total amount
     */
    protected $amount;

    /**
     * @var CurrencyInterface
     *
     * Currency for the amounts stored in this entity
     */
    protected $currency;

    /**
     * Gets the product or products amount with tax
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getProductAmount()
    {
        return Money::create(
            $this->productAmount,
            $this->productCurrency
        );
    }

    /**
     * Sets the product or products amount with tax
     *
     * @param MoneyInterface $amount product amount with tax
     *
     * @return $this Self object
     */
    public function setProductAmount(MoneyInterface $amount)
    {
        $this->productAmount = $amount->getAmount();
        $this->productCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the total amount with tax
     *
     * @return MoneyInterface price with tax
     */
    public function getAmount()
    {
        return Money::create(
            $this->amount,
            $this->currency
        );
    }

    /**
     * Sets the total amount with tax
     *
     * @param MoneyInterface $amount amount without tax
     *
     * @return $this Self object
     */
    public function setAmount(MoneyInterface $amount)
    {
        $this->amount = $amount->getAmount();
        $this->currency = $amount->getCurrency();

        return $this;
    }
}
