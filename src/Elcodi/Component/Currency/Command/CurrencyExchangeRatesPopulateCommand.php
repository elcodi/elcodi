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

namespace Elcodi\Component\Currency\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;
use Elcodi\Component\Currency\Populator\CurrencyExchangeRatesPopulator;

/**
 * Class CurrencyExchangeRatesPopulateCommand.
 */
class CurrencyExchangeRatesPopulateCommand extends AbstractElcodiCommand
{
    /**
     * @var CurrencyExchangeRatesPopulator
     *
     * ExchangeRates populator
     */
    private $currencyExchangeRatesPopulator;

    /**
     * Construct method.
     *
     * @param CurrencyExchangeRatesPopulator $currencyExchangeRatesPopulator CurrencyExchangeRates populator
     */
    public function __construct(CurrencyExchangeRatesPopulator $currencyExchangeRatesPopulator)
    {
        parent::__construct();

        $this->currencyExchangeRatesPopulator = $currencyExchangeRatesPopulator;
    }

    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:exchangerates:populate')
            ->setDescription('Populates exchange rates');
    }

    /**
     * This command loads all the exchange rates from base_currency to all available
     * currencies.
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->startCommand($output);

        $this
            ->currencyExchangeRatesPopulator
            ->populate($output);

        $this->finishCommand($output);
    }
}
