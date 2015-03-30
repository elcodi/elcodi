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

use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\Interfaces\CurrencyExchangeRatesProviderAdapterInterface;

/**
 * Class CurrencyExchangeRatesProvider
 */
class CurrencyExchangeRatesProvider
{
    /**
     * @var CurrencyExchangeRatesProviderAdapterInterface
     *
     * openExchangeRatesService
     */
    protected $exchangeRatesAdapter;

    /**
     * @var array
     *
     * Exchange rates
     */
    protected $exchangeRates;

    /**
     * Build method
     *
     * @param CurrencyExchangeRatesProviderAdapterInterface $exchangeRatesAdapter ExchangeRates adapter
     */
    public function __construct(CurrencyExchangeRatesProviderAdapterInterface $exchangeRatesAdapter)
    {
        $this->exchangeRatesAdapter = $exchangeRatesAdapter;
        $this->exchangeRates = [];
    }

    /**
     * Get all available currencies for this Exchange Rates provider
     *
     * @return array in the form of 'ISOCODE' => 'Currency description'
     */
    public function getCurrencies()
    {
        return $this->exchangeRatesAdapter->getCurrencies();
    }

    /**
     * Return exchange rates from $from to $to
     *
     * @param string       $fromCode ISO code of source currency
     * @param string|array $toCodes  ISO code of target currency, or array with ISO codes of targets
     *
     * @return array in the form of 'ISOCODE' => (float) exchange rate
     */
    public function getExchangeRates($fromCode, $toCodes = [])
    {
        if (!is_array($toCodes)) {
            $toCodes = [$toCodes];
        }

        if (empty($this->exchangeRates)) {
            $this->exchangeRates = $this->exchangeRatesAdapter->getExchangeRates();
        }

        if (empty($this->exchangeRates)) {
            return [];
        }

        $baseExchangeRate = $this->exchangeRates[$fromCode];

        $exchangeRates = [];
        foreach ($toCodes as $code) {
            $exchangeRates[$code] = ($this->exchangeRates[$code] / $baseExchangeRate);
        }

        return $exchangeRates;
    }
}
