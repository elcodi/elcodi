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

namespace Elcodi\Component\Currency\Populator;

use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\Interfaces\CurrencyExchangeRatesProviderAdapterInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyExchangeRateInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Repository\CurrencyRepository;

/**
 * Class CurrencyExchangeRatesPopulator.
 */
class CurrencyExchangeRatesPopulator
{
    /**
     * @var CurrencyExchangeRatesProviderAdapterInterface
     *
     * CurrencyExchangeRates adapter
     */
    private $currencyExchangeRatesAdapter;

    /**
     * @var ObjectDirector
     *
     * CurrencyExchangeRate object director
     */
    private $currencyExchangeRateObjectDirector;

    /**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    private $currencyRepository;

    /**
     * @var string
     *
     * Default currency
     */
    private $defaultCurrency;

    /**
     * Construct method.
     *
     * @param CurrencyExchangeRatesProviderAdapterInterface $currencyExchangeRatesAdapter       ExchangeRates adapter
     * @param ObjectDirector                                $currencyExchangeRateObjectDirector Currency Exchange rate object director
     * @param CurrencyRepository                            $currencyRepository                 Currency repository
     * @param string                                        $defaultCurrency                    Default currency
     */
    public function __construct(
        CurrencyExchangeRatesProviderAdapterInterface $currencyExchangeRatesAdapter,
        ObjectDirector $currencyExchangeRateObjectDirector,
        CurrencyRepository $currencyRepository,
        $defaultCurrency
    ) {
        $this->currencyExchangeRatesAdapter = $currencyExchangeRatesAdapter;
        $this->currencyExchangeRateObjectDirector = $currencyExchangeRateObjectDirector;
        $this->currencyRepository = $currencyRepository;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * Populates the exchange rates.
     *
     * @return $this Self object
     */
    public function populate()
    {
        $currenciesCodes = [];
        $currencies = $this
            ->currencyRepository
            ->findAll();

        /**
         * Create an array of all active currency codes.
         *
         * @var CurrencyInterface $currency
         */
        foreach ($currencies as $currency) {
            if ($currency->getIso() != $this->defaultCurrency) {
                $currenciesCodes[] = $currency->getIso();
            }
        }

        /**
         * Get rates for all of the enabled and active currencies.
         */
        $rates = $this
            ->currencyExchangeRatesAdapter
            ->getExchangeRates(
                $this->defaultCurrency,
                $currenciesCodes
            );

        /**
         * @var CurrencyInterface $sourceCurrency
         */
        $sourceCurrency = $this
            ->currencyRepository
            ->findOneBy([
                'iso' => $this->defaultCurrency,
            ]);

        /**
         * [
         *      "EUR" => "1,378278",
         *      "YEN" => "0,784937",
         * ].
         */
        foreach ($rates as $code => $rate) {

            /**
             * @var CurrencyInterface $targetCurrency
             */
            $targetCurrency = $this
                ->currencyRepository
                ->findOneBy([
                    'iso' => $code,
                ]);

            if (!($targetCurrency instanceof CurrencyInterface)) {
                continue;
            }

            /**
             * check if this is a new exchange rate, or if we have to
             * create a new one.
             */
            $exchangeRate = $this
                ->currencyExchangeRateObjectDirector
                ->findOneBy([
                    'sourceCurrency' => $sourceCurrency,
                    'targetCurrency' => $targetCurrency,
                ]);

            if (!($exchangeRate instanceof CurrencyExchangeRateInterface)) {
                $exchangeRate = $this
                    ->currencyExchangeRateObjectDirector
                    ->create();
            }

            $exchangeRate
                ->setExchangeRate($rate)
                ->setSourceCurrency($sourceCurrency)
                ->setTargetCurrency($targetCurrency);

            $this
                ->currencyExchangeRateObjectDirector
                ->save($exchangeRate);
        }

        return $this;
    }
}
