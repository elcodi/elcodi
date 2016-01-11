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

namespace Elcodi\Component\Currency\Entity\Interfaces;

/**
 * Interface MoneyInterface.
 */
interface MoneyInterface
{
    /**
     * Gets the Money amount.
     *
     * @return int Amount
     */
    public function getAmount();

    /**
     * Gets the Currency.
     *
     * @return CurrencyInterface Currency
     */
    public function getCurrency();

    /**
     * Compares current Money object to another.
     *
     * Will return -1, 0, 1 if the amount of this Money object
     * is respectively less than, equal to, or greater than the other.
     *
     * This is useful when using it as a compare function
     * for usort() and the likes.
     *
     * @param MoneyInterface $other
     *
     * @return int Comparison value
     */
    public function compareTo(MoneyInterface $other);

    /**
     * Adds a Money and returns the result as a new Money.
     *
     * @param MoneyInterface $other Other money
     *
     * @return MoneyInterface New money instance as a result of addition
     *                        between current object and given as a parameter
     */
    public function add(MoneyInterface $other);

    /**
     * Subtracts a Money and returns the result as a new Money.
     *
     * @param MoneyInterface $other Other money
     *
     * @return MoneyInterface New money instance as a result of subtraction
     *                        between current object and given as a parameter
     */
    public function subtract(MoneyInterface $other);

    /**
     * Multiplies current Money amount by a factor returns the result as a new Money.
     *
     * @param float $factor Factor
     *
     * @return MoneyInterface New money instance with amount multiplied by factor
     */
    public function multiply($factor);

    /**
     * Tells if a Money has the same value as current Money object.
     *
     * @param MoneyInterface $other
     *
     * @return bool Current money equals given as parameter
     */
    public function equals(MoneyInterface $other);

    /**
     * Tells if a Money value is greater than current Money object.
     *
     * @param MoneyInterface $other
     *
     * @return bool Current money is greater than given as parameter
     */
    public function isGreaterThan(MoneyInterface $other);

    /**
     * Tells if a Money value is less than current Money object.
     *
     * @param MoneyInterface $other
     *
     * @return bool Current money is less than given as parameter
     */
    public function isLessThan(MoneyInterface $other);
}
