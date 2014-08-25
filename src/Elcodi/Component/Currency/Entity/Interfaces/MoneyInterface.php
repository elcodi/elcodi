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

namespace Elcodi\Component\Currency\Entity\Interfaces;

/**
 * MoneyInterface
 */
interface MoneyInterface
{
    /**
     * Adds a Money and returns the result as a new Money
     *
     * @param MoneyInterface $other
     *
     * @return MoneyInterface
     */
    public function add(MoneyInterface $other);

    /**
     * Tells if a Money value is less than current Money object
     *
     * @param MoneyInterface $other
     *
     * @return bool
     */
    public function isLessThan(MoneyInterface $other);

    /**
     * Multiplies current Money amount by a factor returns the result as a new Money
     *
     * @param float $factor
     *
     * @return MoneyInterface
     */
    public function multiply($factor);

    /**
     * Tells if a Money has the same value as current Money object
     *
     * @param MoneyInterface $other
     *
     * @return bool
     */
    public function equals(MoneyInterface $other);

    /**
     * Compares current Money object to another
     *
     * Will return -1, 0, 1 if the amount of this Money object
     * is respectively less than, equal to, or greater than the other.
     *
     * This is useful when using it as a compare function
     * for usort() and the likes.
     *
     * @param MoneyInterface $other
     *
     * @return MoneyInterface
     */
    public function compareTo(MoneyInterface $other);

    /**
     * Subtracts a Money and returns the result as a new Money
     *
     * @param MoneyInterface $other
     *
     * @return MoneyInterface
     */
    public function subtract(MoneyInterface $other);

    /**
     * Tells if a Money value is greater than current Money object
     *
     * @param MoneyInterface $other
     *
     * @return bool
     */
    public function isGreaterThan(MoneyInterface $other);

    /**
     * Sets the amount
     *
     * @param integer $amount Amount
     *
     * @return MoneyInterface self Object
     */
    public function setAmount($amount);

    /**
     * Gets the Money amount
     *
     * @return int
     */
    public function getAmount();

    /**
     * Set currency
     *
     * @param CurrencyInterface $currency Currency
     *
     * @return MoneyInterface self Object
     */
    public function setCurrency(CurrencyInterface $currency);

    /**
     * Gets the Currency
     *
     * @return CurrencyInterface
     */
    public function getCurrency();

}
