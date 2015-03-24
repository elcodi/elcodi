<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider;

use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\Interfaces\CurrencyExchangeRatesProviderAdapterInterface;

/**
 * Class DummyProviderAdapter
 */
class DummyProviderAdapter implements CurrencyExchangeRatesProviderAdapterInterface
{
    /**
     * Get the latest exchange rates
     *
     * @param array  $symbols array of currency codes to get the rates for.
     * @param string $base    Base currency, default NULL (gets it from config)
     *
     * @return array
     */
    public function getExchangeRates(array $symbols = [], $base = null)
    {
        return [];
    }

    /**
     * Gets a list of all available currencies
     *
     * @return array Currencies
     */
    public function getCurrencies()
    {
        return [];
    }
}
