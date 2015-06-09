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

namespace Elcodi\Component\Cart\Entity\Traits;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Trait for entities that hold prices.
 *
 * CartLine and OrderLine entities usually will have this trait.
 *
 * A currency is needed so that a {@see Money} value object can be
 * exploited when doing currency arithmetics. When Currency is not
 * set, it is not possible to return a Money object, so getters
 * will return null
 */
trait PriceTrait
{
    /**
     * @var integer
     *
     * Product amount without taxes
     */
    protected $preTaxProductAmount;

    /**
     * @var integer
     *
     * Tax amount for product
     */
    protected $taxProductAmount;

    /**
     * @var integer
     *
     * Product amount with taxes
     *
     * Represents the sum of preTaxProductAmount and taxProductAmount
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
     * Line amount without taxes
     */
    protected $preTaxAmount;

    /**
     * @var integer
     *
     * Tax line amount
     */
    protected $taxAmount;

    /**
     * @var integer
     *
     * Line amount with taxes
     */
    protected $amount;

    /**
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
     *
     * Currency for the amounts stored in this entity
     */
    protected $currency;

    /**
     * Gets the product or products amount without taxes
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Product amount with tax
     */
    public function getPreTaxProductAmount()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->preTaxProductAmount,
            $this->productCurrency
        );
    }

    /**
     * Gets the amount of taxes applied to the product
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Product amount with tax
     */
    public function getTaxProductAmount()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->taxProductAmount,
            $this->productCurrency
        );
    }

    /**
     * Gets the product or products amount with taxes
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
     * Sets the product or products amount without taxes
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount product amount with tax
     *
     * @return $this Self object
     */
    public function setPreTaxProductAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->preTaxProductAmount = $amount->getAmount();
        $this->productCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Sets the amount of taxes applied to the product
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount product amount with tax
     *
     * @return $this Self object
     */
    public function setTaxProductAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->taxProductAmount = $amount->getAmount();
        $this->productCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Sets the product or products amount with taxes
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount product amount with tax
     *
     * @return $this Self object
     */
    public function setProductAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->productAmount = $amount->getAmount();
        $this->productCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the total line amount without taxes
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Product amount with tax
     */
    public function getPreTaxAmount()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->preTaxAmount,
            $this->currency
        );
    }

    /**
     * Gets the amount of taxes applied to this line
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Product amount with tax
     */
    public function getTaxAmount()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->taxAmount,
            $this->currency
        );
    }

    /**
     * Gets the total line amount with taxes
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Product amount with tax
     */
    public function getAmount()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->amount,
            $this->currency
        );
    }

    /**
     * Sets the total line amount without taxes
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface price with tax
     *
     * @return $this Self object
     */
    public function setPreTaxAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->preTaxAmount = $amount->getAmount();
        $this->currency = $amount->getCurrency();

        return $this;
    }

    /**
     * Sets the amount of taxes applied to this line
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface price with tax
     *
     * @return $this Self object
     */
    public function setTaxAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->taxAmount = $amount->getAmount();
        $this->currency = $amount->getCurrency();

        return $this;
    }

    /**
     * Sets the total line amount with taxes
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount amount without tax
     *
     * @return $this Self object
     */
    public function setAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->amount = $amount->getAmount();
        $this->currency = $amount->getCurrency();

        return $this;
    }
}
