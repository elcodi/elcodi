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

namespace Elcodi\Component\Currency\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyExchangeRateInterface;
use Elcodi\Component\Currency\Factory\CurrencyExchangeRateFactory;
use Elcodi\Component\Currency\Repository\CurrencyExchangeRateRepository;
use Elcodi\Component\Currency\Repository\CurrencyRepository;
use Elcodi\Component\Currency\Services\ExchangeRatesProvider;

/**
 * Class LoadExchangeRatesCommand
 */
class LoadExchangeRatesCommand extends Command
{
    /**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    protected $currencyRepository;

    /**
     * @var CurrencyExchangeRateFactory
     *
     * CurrencyExchangeRate factory
     */
    protected $currencyExchangeRateFactory;

    /**
     * @var CurrencyExchangeRateRepository
     *
     * CurrencyExchangeRate repository
     */
    protected $currencyExchangeRateRepository;

    /**
     * @var ExchangeRatesProvider
     *
     * ExchangeRates provider
     */
    protected $exchangeRatesProvider;

    /**
     * @var ObjectManager
     *
     * ExchangeRate object manager
     */
    protected $exchangeRateObjectManager;

    /**
     * @var string
     *
     * Currency namespace
     */
    protected $currencyNamespace;

    /**
     * @var string
     *
     * CurrencyExchangeRate namespace
     */
    protected $currencyExchangeRateNamespace;

    /**
     * @var string
     *
     * Default currency
     */
    protected $defaultCurrency;

    /**
     * Construct method
     *
     * @param ObjectManager               $currencyObjectManager             Currency object manager
     * @param ObjectManager               $currencyExchangeRateObjectManager CurrencyExchangeRate object manager
     * @param CurrencyExchangeRateFactory $currencyExchangeRateFactory       CurrencyExchangeRate factory
     * @param ExchangeRatesProvider       $exchangeRatesProvider             ExchangeRates provider
     * @param string                      $currencyNamespace                 Currency namespace
     * @param string                      $currencyExchangeRateNamespace     CurrencyExchangeRate namespace
     * @param string                      $defaultCurrency                   Default currency
     */
    public function __construct(
        ObjectManager $currencyObjectManager,
        ObjectManager $currencyExchangeRateObjectManager,
        CurrencyExchangeRateFactory $currencyExchangeRateFactory,
        ExchangeRatesProvider $exchangeRatesProvider,
        $currencyNamespace,
        $currencyExchangeRateNamespace,
        $defaultCurrency
    )
    {
        parent::__construct();

        $this->currencyObjectManager = $currencyObjectManager;
        $this->currencyExchangeRateObjectManager = $currencyExchangeRateObjectManager;
        $this->currencyExchangeRateFactory = $currencyExchangeRateFactory;
        $this->exchangeRatesProvider = $exchangeRatesProvider;
        $this->currencyNamespace = $currencyNamespace;
        $this->currencyExchangeRateNamespace = $currencyExchangeRateNamespace;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:currency:loadexchangerates')
            ->setDescription('Loads exchange rates');
    }

    /**
     * This command loads all the exchange rates from base_currency to all available
     * currencies
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var ObjectRepository $currencyRepository
         * @var ObjectRepository $currencyExchangeRateRepository
         */
        $currencyRepository = $this
            ->currencyObjectManager
            ->getRepository($this->currencyNamespace);

        $currencyExchangeRateRepository = $this
            ->currencyExchangeRateObjectManager
            ->getRepository($this->currencyExchangeRateNamespace);

        $currencies = $this
            ->currencyRepository
            ->findBy([
                'enabled' => true
            ]);

        //extract target currency codes
        $currenciesCodes = array();
        foreach ($currencies as $activeCurrency) {
            if ($activeCurrency->getIso() != $this->defaultCurrency) {
                $currenciesCodes[] = $activeCurrency->getIso();
            }
        }

        //get rates for all of the enabled and active currencies
        $rates = $this
            ->exchangeRatesProvider
            ->getExchangeRates(
                $this->defaultCurrency,
                $currenciesCodes
            );

        foreach ($rates as $code => $rate) {

            $sourceCurrency = $currencyRepository
                ->findOneBy([
                    'iso' => $this->defaultCurrency
                ]);

            $targetCurrency = $currencyRepository
                ->findOneBy([
                    'iso' => $code
                ]);

            //check if this is a new exchange rate, or if we have to create a new one
            $exchangeRate = $currencyExchangeRateRepository
                ->findOneBy([
                    'sourceCurrency' => $sourceCurrency,
                    'targetCurrency' => $targetCurrency
                ]);

            if (!($exchangeRate instanceof CurrencyExchangeRateInterface)) {

                $exchangeRate = $this->currencyExchangeRateFactory->create();
            }

            $exchangeRate->setExchangeRate($rate);
            $exchangeRate->setSourceCurrency($sourceCurrency);
            $exchangeRate->setTargetCurrency($targetCurrency);

            if (!$exchangeRate->getId()) {

                $this
                    ->exchangeRateObjectManager
                    ->persist($exchangeRate);
            }
        }

        $this
            ->exchangeRateObjectManager
            ->flush();
    }
}
