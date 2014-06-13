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

namespace Elcodi\CurrencyBundle\Services\Interfaces;

/**
 * Interface ExchangeRatesServiceInterface
 */
interface ExchangeRatesServiceInterface
{
    /**
     * Get the latest exchange rates
     *
     * @param array  $symbols array of currency codes to get the rates for.
     * @param string $base    Base currency, default NULL (gets it from config)
     *
     * @return array
     */
    public function getLatest(array $symbols = array(), $base = null);

    /**
     * Gets a list of all available currencies
     *
     * @return array Currencies
     */
    public function getCurrencies();
}
