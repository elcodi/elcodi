<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CurrencyBundle\Services;

use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Exception\CurrencyNotConvertibleException;

/**
 * Class CurrencyConverter
 *
 * This service provides a way of converting Amounts between different
 * currencies
 */
class CurrencyConverter
{
    /**
     * @var array
     *
     * An array with currencyExchange rates
     */
    protected $currencyExchangeRates;

    /**
     * @var array
     *
     * An array with the currency symbols
     */
    protected $currencySymbols;

    /**
     * Construct method
     *
     * @param array $currencyExchangeRates list of exchange rates
     * @param array $currencySymbols       list of currency symbols
     */
    public function __construct(
        array $currencyExchangeRates,
        array $currencySymbols
    )
    {
        $this->currencyExchangeRates = $currencyExchangeRates;
        $this->currencySymbols = $currencySymbols;
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
    )
    {
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
    public function convertCurrency(
        CurrencyInterface $currencyFrom,
        CurrencyInterface $currencyTo,
        $amount
    )
    {
        $currencyRate = 1.0;
        $isoCurrencyFrom = $currencyFrom->getIso();
        $isoCurrencyTo = $currencyTo->getIso();

        if ($currencyFrom->getId() != $currencyTo->getId()) {

            if (
                isset($this->currencyExchangeRates[$isoCurrencyFrom]) &&
                isset($this->currencyExchangeRates[$isoCurrencyFrom][$isoCurrencyTo])
            ) {

                $currencyRate = $this->currencyExchangeRates[$isoCurrencyFrom][$isoCurrencyTo];

            } else {

                /**
                 * No CurrencyRate can be found
                 */
                throw new CurrencyNotConvertibleException;
            }
        }

        $convertedAmount = $amount * $currencyRate;

        return Money::create($convertedAmount, $currencyTo);
    }
}
