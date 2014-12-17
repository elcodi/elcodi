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

namespace Elcodi\Component\Currency\Entity;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Class NullMoney
 *
 * Null Object implementation for a MoneyInterface object
 */
class NullMoney extends StubMoney implements MoneyInterface
{
    /**
     * NullMoney constructor is used only to preserve
     * the protected accessor
     */
    protected function __construct()
    {
    }

    /**
     * Gets the Money amount
     *
     * @return integer Amount
     */
    public function getAmount()
    {
        return 0;
    }

    /**
     * Gets the Currency
     *
     * @return null
     */
    public function getCurrency()
    {
        return null;
    }

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
     * @return null
     */
    public function compareTo(MoneyInterface $other)
    {
        return $other;
    }

    /**
     * Adds a Money and returns the result as a new Money
     *
     * @param MoneyInterface $other Other Money
     *
     * @return $this self Object
     */
    public function add(MoneyInterface $other)
    {
        return $other;
    }

    /**
     * Subtracts a Money and returns the result as a new Money
     *
     * @param MoneyInterface $other
     *
     * @return $this self Object
     */
    public function subtract(MoneyInterface $other)
    {
        return $other;
    }

    /**
     * Multiplies current Money amount by a factor
     * and returns the result as a new Money
     *
     * @param float $factor Factor
     *
     * @return $this self Object
     */
    public function multiply($factor)
    {
        return $this;
    }

    /**
     * Tells if a Money has the same value as current Money object
     *
     * @param MoneyInterface $other
     *
     * @return null
     */
    public function equals(MoneyInterface $other)
    {
        return null;
    }

    /**
     * Tells if a Money value is greater than current Money object
     *
     * @param MoneyInterface $other
     *
     * @return null
     */
    public function isGreaterThan(MoneyInterface $other)
    {
        return null;
    }

    /**
     * Tells if a Money value is less than current Money object
     *
     * @param MoneyInterface $other Other Money
     *
     * @return null
     */
    public function isLessThan(MoneyInterface $other)
    {
        return null;
    }

    /**
     * Returns a new instance of a NullMoney object
     *
     * @return NullMoney
     */
    public static function create()
    {
        return new NullMoney();
    }
}
