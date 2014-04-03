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

namespace Elcodi\CurrencyBundle\Entity\Interfaces;

/**
 * Interface CurrencyExchangeRateInterface
 *
 * @package Elcodi\CurrencyBundle\Entity\Interfaces
 */
interface CurrencyExchangeRateInterface
{
    /**
     * Set the source Currency
     *
     * @param CurrencyInterface $currency
     *
     * @return CurrencyExchangeRateInterface self object
     */
    public function setSourceCurrency(CurrencyInterface $currency);

    /**
     * Get the source Currency
     *
     * @return CurrencyInterface
     */
    public function getSourceCurrency();

    /**
     * Set the target currency
     *
     * @param CurrencyInterface $currency
     *
     * @return CurrencyExchangeRateInterface self object
     */
    public function setTargetCurrency(CurrencyInterface $currency);

    /**
     * Get the target Currency
     *
     * @return CurrencyInterface
     */
    public function getTargetCurrency();

    /**
     * Sets the exchange rate
     *
     * @param float $exchangeRate the exchange rate
     *
     * @return CurrencyExchangeRateInterface self object
     */
    public function setExchangeRate($exchangeRate);

    /**
     * Gets the exchange rate
     *
     * @return float The exchange rate
     */
    public function getExchangeRate();
}