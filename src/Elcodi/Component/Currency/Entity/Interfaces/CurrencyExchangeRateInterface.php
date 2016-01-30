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

namespace Elcodi\Component\Currency\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface CurrencyExchangeRateInterface.
 */
interface CurrencyExchangeRateInterface extends IdentifiableInterface
{
    /**
     * Set the source Currency.
     *
     * @param CurrencyInterface $currency
     *
     * @return $this Self object
     */
    public function setSourceCurrency(CurrencyInterface $currency);

    /**
     * Get the source Currency.
     *
     * @return CurrencyInterface
     */
    public function getSourceCurrency();

    /**
     * Set the target currency.
     *
     * @param CurrencyInterface $currency
     *
     * @return $this Self object
     */
    public function setTargetCurrency(CurrencyInterface $currency);

    /**
     * Get the target Currency.
     *
     * @return CurrencyInterface
     */
    public function getTargetCurrency();

    /**
     * Sets the exchange rate.
     *
     * @param float $exchangeRate the exchange rate
     *
     * @return $this Self object
     */
    public function setExchangeRate($exchangeRate);

    /**
     * Gets the exchange rate.
     *
     * @return float The exchange rate
     */
    public function getExchangeRate();
}
