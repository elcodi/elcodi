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

namespace Elcodi\Component\Currency\Entity;

use SebastianBergmann\Money\Currency as WrappedCurrency;
use SebastianBergmann\Money\Money as WrappedMoney;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Class Money.
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
     * @var int
     *
     * Money amount
     */
    private $amount;

    /**
     * @var WrappedMoney
     *
     * Wrapped Money Value Object
     */
    private $wrappedMoney;

    /**
     * @var CurrencyInterface
     *
     * Represents the Currency for current Money
     */
    private $currency;

    /**
     * Simple Money Value Object constructor.
     *
     * @param int               $amount   Amount
     * @param CurrencyInterface $currency Currency
     */
    protected function __construct($amount, CurrencyInterface $currency)
    {
        $this->amount = intval($amount);
        $this->currency = $currency;

        $this->wrappedMoney = new WrappedMoney(
            $this->amount,
            new WrappedCurrency($currency->getIso())
        );
    }

    /**
     * Gets the Money Currency.
     *
     * @return CurrencyInterface Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Gets the Money amount.
     *
     * @return int Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Gets the monetary value represented by this object converted to its base
     * units.
     *
     * @return float
     */
    public function getConvertedAmount()
    {
        return $this
            ->wrappedMoney
            ->getConvertedAmount();
    }

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
    public function compareTo(MoneyInterface $other)
    {
        return $this
            ->wrappedMoney
            ->compareTo($this->newWrappedMoneyFromMoney($other));
    }

    /**
     * Adds a Money and returns the result as a new Money.
     *
     * @param MoneyInterface $other Other money
     *
     * @return MoneyInterface New money instance as a result of addition
     *                        between current object and given as a parameter
     */
    public function add(MoneyInterface $other)
    {
        $wrappedMoney = $this
            ->wrappedMoney
            ->add($this->newWrappedMoneyFromMoney($other));

        return self::create(
            $wrappedMoney->getAmount(),
            $other->getCurrency()
        );
    }

    /**
     * Subtracts a Money and returns the result as a new Money.
     *
     * @param MoneyInterface $other Other money
     *
     * @return MoneyInterface New money instance as a result of subtraction
     *                        between current object and given as a parameter
     */
    public function subtract(MoneyInterface $other)
    {
        $wrappedMoney = $this
            ->wrappedMoney
            ->subtract($this->newWrappedMoneyFromMoney($other));

        return self::create(
            $wrappedMoney->getAmount(),
            $other->getCurrency()
        );
    }

    /**
     * Multiplies current Money amount by a factor returns the result as a new
     * Money.
     *
     * @param float $factor Factor
     *
     * @return MoneyInterface New money instance with amount multiplied by factor
     */
    public function multiply($factor)
    {
        $wrappedMoney = $this
            ->wrappedMoney
            ->multiply($factor);

        return self::create(
            $wrappedMoney->getAmount(),
            $this->getCurrency()
        );
    }

    /**
     * Tells if a Money has the same value as current Money object.
     *
     * @param MoneyInterface $other
     *
     * @return bool Current money equals given as parameter
     */
    public function equals(MoneyInterface $other)
    {
        return $this->compareTo($other) == 0;
    }

    /**
     * Tells if a Money value is greater than current Money object.
     *
     * @param MoneyInterface $other
     *
     * @return bool Current money is greater than given as parameter
     */
    public function isGreaterThan(MoneyInterface $other)
    {
        return $this
            ->wrappedMoney
            ->greaterThan($this->newWrappedMoneyFromMoney($other));
    }

    /**
     * Tells if a Money value is less than current Money object.
     *
     * @param MoneyInterface $other
     *
     * @return bool Current money is less than given as parameter
     */
    public function isLessThan(MoneyInterface $other)
    {
        return $this
            ->wrappedMoney
            ->lessThan($this->newWrappedMoneyFromMoney($other));
    }

    /**
     * Returns a new WrappedMoney given a MoneyInterface.
     *
     * @param MoneyInterface $money Money
     *
     * @return WrappedMoney WrappedMoney new instance
     */
    private function newWrappedMoneyFromMoney(MoneyInterface $money)
    {
        return new WrappedMoney(
            $money->getAmount(),
            new WrappedCurrency(
                $money
                    ->getCurrency()
                    ->getIso()
            )
        );
    }

    /**
     * Returns a new instance of a Money object.
     *
     * This factory should be the only process to instantiate a
     * object implementing MoneyInterface.
     *
     * In order to return a proper Money value object, an integer
     * amount and a Currency object implementing CurrencyInterface
     * are needed.
     *
     * @param int               $amount   Amount
     * @param CurrencyInterface $currency Currency
     *
     * @return MoneyInterface new Money instance
     */
    public static function create(
        $amount,
        CurrencyInterface $currency
    ) {
        return new self($amount, $currency);
    }
}
