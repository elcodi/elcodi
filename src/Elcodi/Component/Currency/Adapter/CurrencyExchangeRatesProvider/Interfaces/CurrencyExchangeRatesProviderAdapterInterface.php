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

namespace Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\Interfaces;

/**
 * Interface CurrencyExchangeRatesProviderAdapterInterface.
 */
interface CurrencyExchangeRatesProviderAdapterInterface
{
    /**
     * Get the latest exchange rates.
     *
     * This method will take in account always that the base currency is USD,
     * and the result must complain this format.
     *
     * [
     *      "EUR" => "1,78342784",
     *      "YEN" => "0,67438268",
     *      ...
     * ]
     *
     * @return array exchange rates
     */
    public function getExchangeRates();
}
