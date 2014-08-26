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
     * Default currency
     */
    protected $defaultCurrency;

    /**
     * Construct method
     *
     * @param CurrencyRepository             $currencyRepository             Currency repository
     * @param CurrencyExchangeRateFactory    $currencyExchangeRateFactory    CurrencyExchangeRate factory
     * @param CurrencyExchangeRateRepository $currencyExchangeRateRepository CurrencyExchangeRate repository
     * @param ExchangeRatesProvider          $exchangeRatesProvider          ExchangeRates provider
     * @param ObjectManager                  $exchangeRateObjectManager      ExchangeRate object manager
     * @param string                         $defaultCurrency                Default currency
     */
    public function __construct(
        CurrencyRepository $currencyRepository,
        CurrencyExchangeRateFactory $currencyExchangeRateFactory,
        CurrencyExchangeRateRepository $currencyExchangeRateRepository,
        ExchangeRatesProvider $exchangeRatesProvider,
        ObjectManager $exchangeRateObjectManager,
        $defaultCurrency
    )
    {
        parent::__construct();

        $this->currencyRepository = $currencyRepository;
        $this->currencyExchangeRateFactory = $currencyExchangeRateFactory;
        $this->currencyExchangeRateRepository = $currencyExchangeRateRepository;
        $this->exchangeRatesProvider = $exchangeRatesProvider;
        $this->exchangeRateObjectManager = $exchangeRateObjectManager;
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

            $sourceCurrency = $this
                ->currencyRepository
                ->findOneByIso([
                    'iso' => $this->defaultCurrency
                ]);

            $targetCurrency = $this->currencyRepository
                ->findOneByIso([
                    'iso' => $code
                ]);

            //check if this is a new exchange rate, or if we have to create a new one
            $exchangeRate = $this
                ->currencyExchangeRateRepository
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
