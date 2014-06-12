<?php
/**
 * Created by PhpStorm.
 * User: zim
 * Date: 6/12/14
 * Time: 4:55 PM
 */

namespace Elcodi\CurrencyBundle\Entity;

use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;

class NullMoney implements MoneyInterface
{
    /**
     * Adds a Money and returns the result as a new Money
     *
     * @param MoneyInterface $other
     *
     * @return MoneyInterface
     */
    public function add(MoneyInterface $other)
    {
        return $this;
    }

    /**
     * Tells if a Money value is less than current Money object
     *
     * @param MoneyInterface $other
     *
     * @return bool
     */
    public function isLessThan(MoneyInterface $other)
    {
        return false;
    }

    /**
     * Multiplies current Money amount by a factor returns the result as a new Money
     *
     * @param float $factor
     *
     * @return MoneyInterface
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
     * @return bool
     */
    public function equals(MoneyInterface $other)
    {
        return false;
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
     * @return MoneyInterface
     */
    public function compareTo(MoneyInterface $other)
    {
        return $this;
    }

    /**
     * Subtracts a Money and returns the result as a new Money
     *
     * @param MoneyInterface $other
     *
     * @return MoneyInterface
     */
    public function subtract(MoneyInterface $other)
    {
        return $this;
    }

    /**
     * Tells if a Money value is greater than current Money object
     *
     * @param MoneyInterface $other
     *
     * @return bool
     */
    public function isGreaterThan(MoneyInterface $other)
    {
        return false;
    }

    /**
     * Gets the Money amount
     *
     * @return int
     */
    public function getAmount()
    {
        return 0;
    }

    /**
     * Gets the Money Currency
     *
     * @return CurrencyInterface
     */
    public function getCurrency()
    {
        return null;
    }
} 