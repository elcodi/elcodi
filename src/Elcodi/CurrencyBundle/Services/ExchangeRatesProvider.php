<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\CurrencyBundle\Services;

use Elcodi\CurrencyBundle\Adapter\Interfaces\ExchangeRatesAdapterInterface;

/**
 * Class ExchangeRatesProvider
 */
class ExchangeRatesProvider
{
    /**
     * @var ExchangeRatesAdapterInterface
     *
     * openExchangeRatesService
     */
    protected $openExchangeRatesService;

    /**
     * @var array
     *
     * Exchange rates
     */
    protected $exchangeRates;

    /**
     * Build method
     *
     * @param ExchangeRatesAdapterInterface $openExchangeRatesService OpenExchangeRates service
     */
    public function __construct(ExchangeRatesAdapterInterface $openExchangeRatesService)
    {
        $this->openExchangeRatesService =  $openExchangeRatesService;
        $this->exchangeRates = [];
    }

    /**
     * Get all available currencies for this Exchange Rates provider
     *
     * @return array in the form of 'ISOCODE' => 'Currency description'
     */
    public function getCurrencies()
    {
        return $this->openExchangeRatesService->getCurrencies();
    }

    /**
     * Return exchange rates from $from to $to
     *
     * @param string       $fromCode ISO code of source currency
     * @param string|array $toCodes  ISO code of target currency, or array with ISO codes of targets
     *
     * @return array in the form of 'ISOCODE' => (float) exchange rate
     */
    public function getExchangeRates($fromCode, $toCodes = array())
    {
        if (!is_array($toCodes)) {
            $toCodes = array($toCodes);
        }

        if (empty($this->exchangeRates)) {
            $this->exchangeRates = $this->openExchangeRatesService->getExchangeRates();
        }

        if (empty($this->exchangeRates)) {
            return [];
        }

        $baseExchangeRate = $this->exchangeRates[$fromCode];

        $exchangeRates = array();
        foreach ($toCodes as $code) {
            $exchangeRates[$code] = ($this->exchangeRates[$code] / $baseExchangeRate);
        }

        return $exchangeRates;
    }
}
