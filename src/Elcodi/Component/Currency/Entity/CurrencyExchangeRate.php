<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Currency\Entity;

use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyExchangeRateInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Class CurrencyExchangeRate.
 */
class CurrencyExchangeRate implements CurrencyExchangeRateInterface
{
    use IdentifiableTrait;

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
     * Set the source Currency.
     *
     * @param CurrencyInterface $currency
     *
     * @return $this Self object
     */
    public function setSourceCurrency(CurrencyInterface $currency)
    {
        $this->sourceCurrency = $currency;

        return $this;
    }

    /**
     * Get the source Currency.
     *
     * @return CurrencyInterface
     */
    public function getSourceCurrency()
    {
        return $this->sourceCurrency;
    }

    /**
     * Set the target currency.
     *
     * @param CurrencyInterface $currency
     *
     * @return $this Self object
     */
    public function setTargetCurrency(CurrencyInterface $currency)
    {
        $this->targetCurrency = $currency;

        return $this;
    }

    /**
     * Get the target Currency.
     *
     * @return CurrencyInterface
     */
    public function getTargetCurrency()
    {
        return $this->targetCurrency;
    }

    /**
     * Sets the exchange rate.
     *
     * @param float $exchangeRate the exchange rate
     *
     * @return $this Self object
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;

        return $this;
    }

    /**
     * Gets the exchange ate.
     *
     * @return float The exchange rate
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }
}
