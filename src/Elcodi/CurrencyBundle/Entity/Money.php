<?php
/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CurrencyBundle\Entity;

use SebastianBergmann\Money\Money as WrappedMoney;
use SebastianBergmann\Money\Currency as WrappedCurrency;

use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;

/**
 * Class Money
 *
 * Wrapper for Sebastian Bergman's {@see Money Value Object}
 *
 * @link https://github.com/sebastianbergmann/money
 *
 * Useful methods will be exposed as defined in {@see MoneyInterface}
 */
class Money implements MoneyInterface
{
    /**
     * @var WrappedMoney
     *
     * Wrapped Money Value Object
     */
    protected $wrappedMoney;

    /**
     * @var CurrencyInterface
     *
     * Represents the Currency for current Money
     */
    protected $currency;

    /**
     * Simple Money Value Object constructor
     *
     * @param $amount
     * @param CurrencyInterface $currency
     */
    public function __construct($amount, CurrencyInterface $currency)
    {
        $amount = intval($amount);

        $this->wrappedMoney = new WrappedMoney($amount, new WrappedCurrency($currency->getIso()));

        $this->currency = $currency;
    }

    /**
     * Gets the Money Currency
     *
     * @return CurrencyInterface
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Gets the Money amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->wrappedMoney->getAmount();
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
        return $this->wrappedMoney->compareTo($this->newWrappedMoneyFromMoney($other));
    }

    /**
     * Adds a Money and returns the result as a new Money
     *
     * @param MoneyInterface $other
     *
     * @return MoneyInterface
     */
    public function add(MoneyInterface $other)
    {
        $wrappedMoney = $this->wrappedMoney->add($this->newWrappedMoneyFromMoney($other));

        return $this->newMoney($wrappedMoney->getAmount(), $other->getCurrency());
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
        $wrappedMoney = $this->wrappedMoney->subtract($this->newWrappedMoneyFromMoney($other));

        return $this->newMoney($wrappedMoney->getAmount(), $other->getCurrency());
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
        $wrappedMoney = $this->wrappedMoney->multiply($factor);

        return $this->newMoney($wrappedMoney->getAmount(), $this->getCurrency());
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
        return $this->compareTo($other) == 0;
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
        return $this->wrappedMoney->greaterThan($this->newWrappedMoneyFromMoney($other));
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
        return $this->wrappedMoney->lessThan($this->newWrappedMoneyFromMoney($other));
    }

    /**
     * Returns a new WrappedMoney given a MoneyInterface
     *
     * @param MoneyInterface $money
     *
     * @return WrappedMoney
     */
    protected function newWrappedMoneyFromMoney(MoneyInterface $money)
    {
        return new WrappedMoney(
            $money->getAmount(),
            new WrappedCurrency($money->getCurrency()->getIso())
        );
    }

    /**
     * Returns a new instance of a Money object
     *
     * @param $amount
     * @param CurrencyInterface $currency
     *
     * @return MoneyInterface
     */
    protected function newMoney($amount, CurrencyInterface $currency)
    {
        return new static($amount, $currency);
    }
}
