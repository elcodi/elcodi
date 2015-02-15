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

namespace Elcodi\Component\Geo\Command;

use DateTime;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Geo\Populator\Interfaces\PopulatorInterface;

/**
 * Class GeoPopulateCommand
 */
class GeoPopulateCommand extends Command implements LoggerAwareInterface
{
    /**
     * @var PopulatorInterface
     *
     * Geo Populator
     */
    protected $geoPopulator;

    /**
     * @var ObjectDirector
     *
     * Location director
     */
    protected $locationDirector;

    /**
     * @var LoggerInterface
     *
     * Logger
     */
    protected $logger;

    /**
     * Construct method
     *
     * @param PopulatorInterface $populator        Populator
     * @param ObjectDirector     $locationDirector Location director
     */
    public function __construct(
        PopulatorInterface $populator,
        ObjectDirector $locationDirector
    ) {
        parent::__construct();

        $this->geoPopulator = $populator;
        $this->locationDirector = $locationDirector;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:geo:populate')
            ->setDescription('populates geo schema')
            ->addArgument(
                'country',
                InputArgument::REQUIRED,
                'What country do you want to populate?'
            )
            ->addOption(
                'reload-source',
                null,
                InputOption::VALUE_NONE,
                'Do you want to reload the source package?'
            );
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
        $countryCodes = $input->getArgument('country');
        $countryCodes = explode(',', $countryCodes);

        $formatter = $output->getFormatter();
        $formatter->setStyle('header', new OutputFormatterStyle('green'));
        $formatter->setStyle('body', new OutputFormatterStyle('white'));

        $output->writeln('');
        $output->writeln('<header>[Geo]</header> <body>This process may take a few minutes. Please, be patient</body>');

        foreach ($countryCodes as $countryCode) {
            $output->writeln('<header>[Geo]</header> <body>Populating country code: '.$countryCode);

            $locations = $this
                ->geoPopulator
                ->populate($countryCode);

            $output->writeln('<header>[Geo]</header> <body>Flushing manager started</body>');

            $start = new DateTime();

            $this
                ->locationDirector
                ->save($locations);

            $finish = new DateTime();
            $elapsed = $finish->diff($start);

            $output->writeln('<header>[Geo]</header> <body>Manager flushed in '.$elapsed->format('%s').' seconds</body>');
        }

        $output->writeln('<header>[Geo]</header> <body>Process finished. Please checkout your database</body>');
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }
}
