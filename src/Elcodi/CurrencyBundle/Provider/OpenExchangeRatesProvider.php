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

namespace Elcodi\CurrencyBundle\Provider;

use Elcodi\CurrencyBundle\Provider\Interfaces\ExchangeRatesProviderInterface;
use Elcodi\CurrencyBundle\Services\Interfaces\ExchangeRatesServiceInterface;

/**
 * Class OpenExchangeRatesProvider
 */
class OpenExchangeRatesProvider implements ExchangeRatesProviderInterface
{

    /**
     * @var ExchangeRatesServiceInterface
     *
     * openExchangeRatesService
     */
    protected $openExchangeRatesService;

    /**
     * @var array
     *
     * Exchange rates
     */
    protected $exchangeRates = array();

    /**
     * Build method
     *
     * @param ExchangeRatesServiceInterface $openExchangeRatesService OpenExchangeRates service
     */
    public function __construct(ExchangeRatesServiceInterface $openExchangeRatesService)
    {
        $this->openExchangeRatesService =  $openExchangeRatesService;
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
            $this->exchangeRates = $this->openExchangeRatesService->getLatest()['rates'];
        }

        $usdToBaseExchangeRate = $this->exchangeRates[$fromCode];

        $exchangeRates = array();
        foreach ($toCodes as $code) {
            $exchangeRates[$code] = ($this->exchangeRates[$code] / $usdToBaseExchangeRate);
        }

        return $exchangeRates;
    }
}
