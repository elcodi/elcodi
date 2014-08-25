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

namespace Elcodi\Component\Cart\Entity\Traits;

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
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
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
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
     *
     * Currency for the amounts stored in this entity
     */
    protected $currency;

    /**
     * Gets the product or products amount with tax
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Product amount with tax
     */
    public function getProductAmount()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->productAmount,
            $this->productCurrency
        );
    }

    /**
     * Sets the product or products amount with tax
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount product amount with tax
     *
     * @return Object self Object
     */
    public function setProductAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->productAmount = $amount->getAmount();
        $this->productCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the total amount with tax
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface price with tax
     */
    public function getAmount()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->amount,
            $this->currency
        );
    }

    /**
     * Sets the total amount with tax
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount amount without tax
     *
     * @return Object self Object
     */
    public function setAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->amount = $amount->getAmount();
        $this->currency = $amount->getCurrency();

        return $this;
    }
}
