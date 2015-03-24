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

namespace Elcodi\Component\Currency\Populator;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyExchangeRateInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Factory\CurrencyExchangeRateFactory;
use Elcodi\Component\Currency\Repository\CurrencyExchangeRateRepository;
use Elcodi\Component\Currency\Repository\CurrencyRepository;
use Elcodi\Component\Currency\Services\CurrencyExchangeRatesProvider;

/**
 * Class CurrencyExchangeRatesPopulator
 */
class CurrencyExchangeRatesPopulator
{
    /**
     * @var ObjectManager
     *
     * CurrencyExchangeRate object manager
     */
    protected $currencyExchangeRateObjectManager;

    /**
     * @var ManagerRegistry
     *
     * Manager Registry
     */
    protected $managerRegistry;

    /**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    protected $currencyRepository;

    /**
     * @var CurrencyExchangeRateRepository
     *
     * CurrencyExchangeRate repository
     */
    protected $currencyExchangeRateRepository;

    /**
     * @var CurrencyExchangeRateFactory
     *
     * CurrencyExchangeRate factory
     */
    protected $currencyExchangeRateFactory;

    /**
     * @var CurrencyExchangeRatesProvider
     *
     * CurrencyExchangeRates provider
     */
    protected $currencyExchangeRatesProvider;

    /**
     * @var ObjectManager
     *
     * ExchangeRate object manager
     */
    protected $exchangeRateObjectManager;

    /**
     * @var string
     *
     * Default currency
     */
    protected $defaultCurrency;

    /**
     * Construct method
     *
     * @param ObjectManager                  $currencyExchangeRateObjectManager Currency Exchange rate object manager
     * @param CurrencyRepository             $currencyRepository                Currency repository
     * @param CurrencyExchangeRateRepository $currencyExchangeRateRepository    Currency Exchange rate repository,
     * @param CurrencyExchangeRateFactory    $currencyExchangeRateFactory       CurrencyExchangeRate factory
     * @param CurrencyExchangeRatesProvider  $currencyExchangeRatesProvider     ExchangeRates provider
     * @param string                         $defaultCurrency                   Default currency
     */
    public function __construct(
        ObjectManager $currencyExchangeRateObjectManager,
        CurrencyRepository $currencyRepository,
        CurrencyExchangeRateRepository $currencyExchangeRateRepository,
        CurrencyExchangeRateFactory $currencyExchangeRateFactory,
        CurrencyExchangeRatesProvider $currencyExchangeRatesProvider,
        $defaultCurrency
    ) {
        $this->currencyExchangeRateObjectManager = $currencyExchangeRateObjectManager;
        $this->currencyRepository = $currencyRepository;
        $this->currencyExchangeRateRepository = $currencyExchangeRateRepository;
        $this->currencyExchangeRateFactory = $currencyExchangeRateFactory;
        $this->currencyExchangeRatesProvider = $currencyExchangeRatesProvider;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * Populates the exchange rates
     *
     * @param OutputInterface $output The output interface
     *
     * @return integer|null|void
     */
    public function populate(OutputInterface $output)
    {
        $currencies = $this
            ->currencyRepository
            ->findBy([
                'enabled' => true,
            ]);

        //extract target currency codes
        $currenciesCodes = [];
        foreach ($currencies as $activeCurrency) {
            if ($activeCurrency->getIso() != $this->defaultCurrency) {
                $currenciesCodes[] = $activeCurrency->getIso();
            }
        }

        //get rates for all of the enabled and active currencies
        $rates = $this
            ->currencyExchangeRatesProvider
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

        foreach ($rates as $code => $rate) {

            /**
             * @var CurrencyInterface $targetCurrency
             */
            $targetCurrency = $this
                ->currencyRepository
                ->findOneBy([
                    'iso' => $code,
                ]);

            //check if this is a new exchange rate, or if we have to create a new one
            $exchangeRate = $this
                ->currencyExchangeRateRepository
                ->findOneBy([
                    'sourceCurrency' => $sourceCurrency,
                    'targetCurrency' => $targetCurrency,
                ]);

            if (!($exchangeRate instanceof CurrencyExchangeRateInterface)) {
                $exchangeRate = $this->currencyExchangeRateFactory->create();
            }

            $exchangeRate->setExchangeRate($rate);
            $exchangeRate->setSourceCurrency($sourceCurrency);
            $exchangeRate->setTargetCurrency($targetCurrency);

            if (!$exchangeRate->getId()) {
                $this
                    ->currencyExchangeRateObjectManager
                    ->persist($exchangeRate);
            }
        }

        $this
            ->currencyExchangeRateObjectManager
            ->flush();
    }
}
