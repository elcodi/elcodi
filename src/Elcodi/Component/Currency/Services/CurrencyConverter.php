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

namespace Elcodi\Component\Currency\Services;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Exception\CurrencyNotConvertibleException;

/**
 * Class CurrencyConverter.
 *
 * This service provides a way of converting Amounts between different
 * currencies
 */
class CurrencyConverter
{
    /**
     * @var ExchangeRateCalculator
     *
     * The exchange rate calculator.
     */
    private $exchangeRateCalculator;

    /**
     * Construct method.
     *
     * @param ExchangeRateCalculator $exchangeRateCalculator Exchange rate
     *                                                       calculator
     */
    public function __construct(
        ExchangeRateCalculator $exchangeRateCalculator
    ) {
        $this->exchangeRateCalculator = $exchangeRateCalculator;
    }

    /**
     * Given an amount, convert it to desired Currency.
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
     * Convert amount between two currencies.
     *
     * If are the same currency, return same amount
     *
     * If is impossible to convert between them, throw Exception
     *
     * @param CurrencyInterface $currencyFrom Currency where to convert from
     * @param CurrencyInterface $currencyTo   Currency where to convert to
     * @param int               $amount       Amount to convert
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

        $exchangeRate = $this
            ->exchangeRateCalculator
            ->calculateExchangeRate(
                $currencyFrom,
                $currencyTo
            );

        return Money::create(
            $amount * $exchangeRate,
            $currencyTo
        );
    }
}
