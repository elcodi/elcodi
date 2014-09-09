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

namespace Elcodi\Component\Currency\Entity\Interfaces;

/**
 * Interface CurrencyExchangeRateInterface
 */
interface CurrencyExchangeRateInterface
{
    /**
     * Set the source Currency
     *
     * @param CurrencyInterface $currency
     *
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function setExchangeRate($exchangeRate);

    /**
     * Gets the exchange rate
     *
     * @return float The exchange rate
     */
    public function getExchangeRate();
}
