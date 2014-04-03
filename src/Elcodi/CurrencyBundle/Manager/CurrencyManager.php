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

namespace Elcodi\CurrencyBundle\Manager;

use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Repository\CurrencyExchangeRateRepository;
use Elcodi\CurrencyBundle\Repository\CurrencyRepository;

/**
 * Class CurrencyManager
 */
class CurrencyManager
{
    /**
     * Build method
     *
     * @param CurrencyRepository             $currencyRepository             Repo for currencies
     * @param CurrencyExchangeRateRepository $currencyExchangeRateRepository Repo for exch. rates
     */
    public function __construct(
        CurrencyRepository $currencyRepository,
        CurrencyExchangeRateRepository $currencyExchangeRateRepository
    )
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyExchangeRateRepository = $currencyExchangeRateRepository;
    }

    /**
     * Given a currency code, returns a list of all exchange rates from this code
     *
     * @param string $currencyCode the iso code of the source currency
     *
     * @return array
     */
    public function getExchangeRateList($currencyCode)
    {
        $exchangeList = [];

        $sourceCurrency = $this->currencyRepository->findOneBy(['iso' => $currencyCode]);

        if (!($sourceCurrency instanceof CurrencyInterface)) {
            return [];
        }

        $exchangeList[$currencyCode] = [];

        $availableExchangeRates = $this->currencyExchangeRateRepository
            ->findBy([
                'sourceCurrency' => $sourceCurrency
            ]);

        foreach ($availableExchangeRates as $exchangeRate) {
            $targetCurrencyIso = $exchangeRate->getTargetCurrency()->getIso();
            $exchangeList[$currencyCode][$targetCurrencyIso] = $exchangeRate->getExchangeRate();
        }

        return $exchangeList;
    }

    /**
     * Get a list of ISO codes => symbols for all active currencies
     *
     * @return array
     */
    public function getSymbols()
    {
        $symbolsList = array();

        $availableCurrencies = $this->currencyRepository->findBy(['enabled' => 1]);

        foreach ($availableCurrencies as $currency) {
            $symbolsList[$currency->getIso()] = $currency->getSymbol();
        }

        return $symbolsList;
    }


    /**
     * Returns a collection with the active currencies
     */
    public function getActiveCurrencies()
    {
        return $this->currencyRepository->findBy(['enabled' => 1]);
    }
}