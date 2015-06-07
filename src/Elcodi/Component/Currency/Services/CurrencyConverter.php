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

namespace Elcodi\Component\Currency\Services;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Exception\CurrencyNotConvertibleException;

/**
 * Class CurrencyConverter
 *
 * This service provides a way of converting Amounts between different
 * currencies
 */
class CurrencyConverter
{
    /**
     * @var boolean
     *
     * Multiply
     */
    const MULTIPLY = true;

    /**
     * @var boolean
     *
     * Multiply
     */
    const DIVIDE = false;

    /**
     * @var CurrencyManager
     *
     * Currency manager
     */
    private $currencyManager;

    /**
     * @var string
     *
     * Currency base
     */
    private $currencyBase;

    /**
     * Construct method
     *
     * @param CurrencyManager $currencyManager Currency Manager
     * @param string          $currencyBase    Currency base
     */
    public function __construct(
        CurrencyManager $currencyManager,
        $currencyBase
    ) {
        $this->currencyManager = $currencyManager;
        $this->currencyBase = $currencyBase;
    }

    /**
     * Given an amount, convert it to desired Currency
     *
     * If amount currency is the same as desired Currency, return itself
     *
     * If is impossible to convert to desired Currency, throw Exception
     *
     * @param MoneyInterface    $money
     * @param CurrencyInterface $currencyTo
     *
     * @return MoneyInterface Money converted
     *
     * @throws CurrencyNotConvertibleException Currencies cannot be converted
     */
    public function convertMoney(
        MoneyInterface $money,
        CurrencyInterface $currencyTo
    ) {
        $currencyFrom = $money->getCurrency();
        $amount = $money->getAmount();

        return $this->convertCurrency(
            $currencyFrom,
            $currencyTo,
            $amount
        );
    }

    /**
     * Convert amount between two currencies
     *
     * If are the same currency, return same amount
     *
     * If is impossible to convert between them, throw Exception
     *
     * @param CurrencyInterface $currencyFrom Currency where to convert from
     * @param CurrencyInterface $currencyTo   Currency where to convert to
     * @param integer           $amount       Amount to convert
     *
     * @return MoneyInterface Money converted
     *
     * @throws CurrencyNotConvertibleException Currencies cannot be converted
     */
    private function convertCurrency(
        CurrencyInterface $currencyFrom,
        CurrencyInterface $currencyTo,
        $amount
    ) {
        if ($currencyFrom->getIso() == $currencyTo->getIso()) {
            return Money::create($amount, $currencyFrom);
        }

        $convertedAmount = $this->convertBetweenIsos(
            $currencyFrom->getIso(),
            $currencyTo->getIso(),
            $amount
        );

        return Money::create($convertedAmount, $currencyTo);
    }

    /**
     * Convert amount between two currencies
     *
     * If are the same currency, return same amount
     *
     * If is impossible to convert between them, throw Exception
     *
     * @param string  $currencyFromIso Currency iso where to convert from
     * @param string  $currencyToIso   Currency iso where to convert to
     * @param integer $amount          Amount to convert
     *
     * @return float value converted
     *
     * @throws CurrencyNotConvertibleException Currencies cannot be converted
     */
    private function convertBetweenIsos(
        $currencyFromIso,
        $currencyToIso,
        $amount
    ) {
        /**
         * If none of given Money is baseCurrency, means we'll need to perform
         * two partial conversions
         */
        if (!in_array($this->currencyBase, [$currencyFromIso, $currencyToIso])) {
            return $this->convertBetweenIsos(
                $this->currencyBase,
                $currencyToIso,
                $this->convertBetweenIsos(
                    $currencyFromIso,
                    $this->currencyBase,
                    $amount
                )
            );
        }

        return ($currencyFromIso === $this->currencyBase)
            ? $this->convertToIso($currencyToIso, $amount, self::MULTIPLY)
            : $this->convertToIso($currencyFromIso, $amount, self::DIVIDE);
    }

    /**
     * Convert Amount given base currency iso
     *
     * @param string  $currencyToIso Currency iso where to convert to
     * @param integer $amount        Amount to convert
     * @param boolean $type          Type of conversion
     *
     * @return float conversion
     *
     * @throws CurrencyNotConvertibleException Currencies cannot be converted
     */
    private function convertToIso($currencyToIso, $amount, $type)
    {
        if (isset($this->currencyManager->getExchangeRateList()[$currencyToIso])) {
            $currencyRate = $this->currencyManager->getExchangeRateList()[$currencyToIso];
        } else {

            /**
             * No CurrencyRate can be found
             */
            throw new CurrencyNotConvertibleException();
        }

        return $type
            ? $amount * $currencyRate['rate']
            : $amount / $currencyRate['rate'];
    }
}
