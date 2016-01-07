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

namespace Elcodi\Component\Cart\Entity\Traits;

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
     * @var int
     *
     * Purchasable amount
     */
    protected $purchasableAmount;

    /**
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
     *
     * Currency for the amounts stored in this entity
     */
    protected $purchasableCurrency;

    /**
     * @var int
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
     * Gets the purchasable or purchasables amount with tax.
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Purchasable amount with tax
     */
    public function getPurchasableAmount()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->purchasableAmount,
            $this->purchasableCurrency
        );
    }

    /**
     * Sets the purchasable or purchasables amount with tax.
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount purchasable amount with tax
     *
     * @return $this Self object
     */
    public function setPurchasableAmount(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->purchasableAmount = $amount->getAmount();
        $this->purchasableCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the total amount with tax.
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
     * Sets the total amount with tax.
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
