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

/**
 * Class DummyExchangeRatesProvider
 */
class DummyExchangeRatesProvider implements ExchangeRatesProviderInterface
{
    /**
     * Get all available currencies for this Exchange Rates provider
     *
     * @return array in the form of 'ISOCODE' => 'Currency description'
     */
    public function getCurrencies()
    {
        return [];
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
        return [];
    }
}
