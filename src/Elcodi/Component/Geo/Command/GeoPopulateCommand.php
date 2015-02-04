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
 */

namespace Elcodi\Component\Geo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Geo\Populator\GeoPopulator;

/**
 * Class GeoPopulateCommand
 */
class GeoPopulateCommand extends Command
{
    /**
     * @var GeoPopulator
     *
     * Geo Populator
     */
    protected $geoPopulator;

    /**
     * Construct method
     *
     * @param GeoPopulator $geoPopulator Geo Populator
     */
    public function __construct(GeoPopulator $geoPopulator)
    {
        parent::__construct();

        $this->geoPopulator = $geoPopulator;
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
        $country = $input->getArgument('country');
        $reloadSource = $input->hasOption('reload-source');
        $formatter = $output->getFormatter();
        $formatter->setStyle('header', new OutputFormatterStyle(
            'green', null, []
        ));
        $formatter->setStyle('body', new OutputFormatterStyle(
            'white', null, []
        ));

        $output->writeln('');
        $output->writeln('<header>[Geo]</header> <body>Populating your database with '.$country.' fixtures</body>');
        $output->writeln('<header>[Geo]</header> <body>This process may take a few minutes. Please, be patient</body>');
        $output->writeln('<header>[Geo]</header> <body>Process started...</body>');

        $this
            ->geoPopulator
            ->populateCountries(
                $output,
                [$country],
                $reloadSource
            );

        $output->writeln('<header>[Geo]</header> <body>Process finished. Please checkout your database</body>');
    }
}
