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

namespace Elcodi\CurrencyBundle\Entity;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyExchangeRateInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;

/**
 * Class CurrencyExchangeRate
 *
 * @package Elcodi\CurrencyBundle\Entity
 */
class CurrencyExchangeRate extends AbstractEntity implements CurrencyExchangeRateInterface
{
    /**
     * @var CurrencyInterface
     *
     * Currency interface for source currency
     */
    protected $sourceCurrency;

    /**
     * @var CurrencyInterface
     *
     * Currency interface for target currency
     */
    protected $targetCurrency;

    /**
     * @var float
     *
     * Exchange rate for source to target conversion
     */
    protected $exchangeRate;

    /**
     * Set the source Currency
     *
     * @param CurrencyInterface $currency
     *
     * @return CurrencyExchangeRateInterface self object
     */
    public function setSourceCurrency(CurrencyInterface $currency)
    {
        $this->sourceCurrency = $currency;

        return $this;
    }

    /**
     * Get the source Currency
     *
     * @return CurrencyInterface
     */
    public function getSourceCurrency()
    {
        return $this->sourceCurrency;
    }

    /**
     * Set the target currency
     *
     * @param CurrencyInterface $currency
     *
     * @return CurrencyExchangeRateInterface self object
     */
    public function setTargetCurrency(CurrencyInterface $currency)
    {
        $this->targetCurrency = $currency;

        return $this;
    }

    /**
     * Get the target Currency
     *
     * @return CurrencyInterface
     */
    public function getTargetCurrency()
    {
        return $this->targetCurrency;
    }

    /**
     * Sets the exchange rate
     *
     * @param float $exchangeRate the exchange rate
     *
     * @return CurrencyExchangeRateInterface self object
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }

    /**
     * Gets the exchange ate
     *
     * @return float The exchange rate
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }
}