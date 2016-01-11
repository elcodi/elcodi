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
use Elcodi\Component\Currency\Exception\CurrencyNotConvertibleException;

/**
 * Class ExchangeRateCalculator.
 *
 * @author Roger Gros <roger@gros.cat>
 */
class ExchangeRateCalculator
{
    /**
     * @var CurrencyManager
     *
     * The currency manager.
     */
    private $currencyManager;

    /**
     * @var string
     *
     * The default exchange currency ISO
     */
    private $defaultExchangeCurrencyIso;

    /**
     * @param CurrencyManager $currencyManager
     * @param string          $defaultExchangeCurrencyIso
     */
    public function __construct(
        CurrencyManager $currencyManager,
        $defaultExchangeCurrencyIso
    ) {
        $this->currencyManager = $currencyManager;
        $this->defaultExchangeCurrencyIso = $defaultExchangeCurrencyIso;
    }

    /**
     * Calculates the exchange rate.
     *
     * @param CurrencyInterface $currencyFrom The currency we are converting from.
     * @param CurrencyInterface $currencyTo   The currency we are converting to.
     *
     * @return float
     *
     * @throws CurrencyNotConvertibleException
     */
    public function calculateExchangeRate(
        CurrencyInterface $currencyFrom,
        CurrencyInterface $currencyTo
    ) {
        $currencyFromIso = $currencyFrom->getIso();
        $currencyToIso = $currencyTo->getIso();

        if ($currencyFromIso == $currencyToIso) {
            return 1.0;
        }

        return $this
            ->calculateExchangeRateBetweenIsos(
                $currencyFromIso,
                $currencyToIso
            );
    }

    /**
     * Calculates the exchange rate between ISOs.
     *
     * @param string $currencyFromIso The currency ISO we are converting from.
     * @param string $currencyToIso   The currency ISO we are converting to.
     *
     * @return float
     *
     * @throws CurrencyNotConvertibleException
     */
    protected function calculateExchangeRateBetweenIsos(
        $currencyFromIso,
        $currencyToIso
    ) {
        $currencyExchangeRates = $this->currencyManager->getExchangeRateList();

        /**
         * We are calculating the exchange from the default currency.
         */
        if (
            $this->defaultExchangeCurrencyIso == $currencyFromIso &&
            isset($currencyExchangeRates[$currencyToIso])
        ) {
            $exchangeRate = $currencyExchangeRates[$currencyToIso]['rate'];
        } /**
         * We are calculating the exchange to the default currency.
         */
        elseif (
            $this->defaultExchangeCurrencyIso == $currencyToIso &&
            isset($currencyExchangeRates[$currencyFromIso])
        ) {
            $exchangeRate = 1 / $currencyExchangeRates[$currencyFromIso]['rate'];
        } /**
         * We use the default money as a bridge to calculate the exchange rate.
         */
        elseif (
            isset($currencyExchangeRates[$currencyFromIso]) &&
            isset($currencyExchangeRates[$currencyToIso])
        ) {
            $exchangeRate = 1 / $currencyExchangeRates[$currencyFromIso]['rate']
                * $currencyExchangeRates[$currencyToIso]['rate'];
        } /**
         * If we reach this point we don't know how to calculate the exchange.
         */
        else {
            throw new CurrencyNotConvertibleException();
        }

        return $exchangeRate;
    }
}
