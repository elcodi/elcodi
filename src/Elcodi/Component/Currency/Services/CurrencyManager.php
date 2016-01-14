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

use Elcodi\Component\Currency\Entity\CurrencyExchangeRate;
use Elcodi\Component\Currency\Repository\CurrencyExchangeRateRepository;
use Elcodi\Component\Currency\Repository\CurrencyRepository;

/**
 * Class CurrencyManager.
 */
class CurrencyManager
{
    /**
     * @var CurrencyRepository
     *
     * Currency Repository
     */
    private $currencyRepository;

    /**
     * @var CurrencyExchangeRateRepository
     *
     * CurrencyExchangeRate Repository
     */
    private $currencyExchangeRateRepository;

    /**
     * @var array
     *
     * Exchange Rate List
     */
    private $exchangeRateList;

    /**
     * @var string
     *
     * The exchange currency ISO.
     */
    private $exchangeCurrencyIso;

    /**
     * Build method.
     *
     * @param CurrencyRepository             $currencyRepository             Currency Repository
     * @param CurrencyExchangeRateRepository $currencyExchangeRateRepository Repo for exch. rates
     * @param string                         $exchangeCurrencyIso            The exchange currency iso
     */
    public function __construct(
        CurrencyRepository $currencyRepository,
        CurrencyExchangeRateRepository $currencyExchangeRateRepository,
        $exchangeCurrencyIso
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->currencyExchangeRateRepository = $currencyExchangeRateRepository;
        $this->exchangeCurrencyIso = $exchangeCurrencyIso;
    }

    /**
     * Given a the currency base, returns a list of all exchange rates.
     *
     * @return array Exchange rate list
     */
    public function getExchangeRateList()
    {
        if (!empty($this->exchangeRateList)) {
            return $this->exchangeRateList;
        }

        $this->exchangeRateList = [];

        $currencyBase = $this
            ->currencyRepository
            ->findOneBy([
                'iso' => $this->exchangeCurrencyIso,
            ]);

        $availableExchangeRates = $this
            ->currencyExchangeRateRepository
            ->findBy([
                'sourceCurrency' => $currencyBase,
            ]);

        /**
         * @var CurrencyExchangeRate $exchangeRate
         */
        foreach ($availableExchangeRates as $exchangeRate) {
            $targetCurrency = $exchangeRate->getTargetCurrency();
            $targetCurrencyIso = $targetCurrency->getIso();

            $this->exchangeRateList[$targetCurrencyIso] = [
                'rate' => $exchangeRate->getExchangeRate(),
                'currency' => $targetCurrency,
            ];
        }

        return $this->exchangeRateList;
    }
}
