<?php

/**
 * This file is part of BeEcommerce.
 *
 * @author Befactory Team
 * @since  2013
 */

namespace Elcodi\CurrencyBundle\Services\Interfaces;

/**
 * Interface ExchangeRatesServiceInterface
 */
Interface ExchangeRatesServiceInterface
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
 