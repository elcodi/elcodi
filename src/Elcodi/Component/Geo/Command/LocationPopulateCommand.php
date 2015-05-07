<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Populator\Interfaces\PopulatorInterface;

/**
 * Class LocationPopulateCommand
 */
class LocationPopulateCommand extends Command
{
    /**
     * @var PopulatorInterface
     *
     * Location Populator
     */
    protected $locationPopulator;

    /**
     * @var ObjectDirector
     *
     * Location director
     */
    protected $locationDirector;

    /**
     * @var DateTimeFactory
     *
     * DateTime Factory
     */
    protected $dateTimeFactory;

    /**
     * Construct method
     *
     * @param PopulatorInterface $locationPopulator Location Populator
     * @param ObjectDirector     $locationDirector  Location director
     * @param DateTimeFactory    $dateTimeFactory   DateTime Factory
     */
    public function __construct(
        PopulatorInterface $locationPopulator,
        ObjectDirector $locationDirector,
        DateTimeFactory $dateTimeFactory
    ) {
        parent::__construct();

        $this->locationPopulator = $locationPopulator;
        $this->locationDirector = $locationDirector;
        $this->dateTimeFactory = $dateTimeFactory;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:locations:populate')
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
     * This command loads all the locations for the received country
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return integer|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');
        $countryCodes = $input->getArgument('country');
        $noInteraction = $input->getOption('no-interaction');

        $countryCodes = explode(',', $countryCodes);

        $formatter = $output->getFormatter();
        $formatter->setStyle('header', new OutputFormatterStyle('green'));
        $formatter->setStyle('body', new OutputFormatterStyle('white'));

        $output->writeln('');

        $message = sprintf(
            '<header>%s</header> <body>%s</body>',
            '[Geo]',
            'This process may take a few minutes. Please, be patient'
        );
        $output->writeln($message);

        foreach ($countryCodes as $countryCode) {
            $country = $this
                ->locationDirector
                ->findOneBy(['code' => $countryCode]);

            if ($country instanceof LocationInterface) {
                if (
                    !$noInteraction &&
                    !$this->confirmRemoval(
                        $countryCode,
                        $dialog,
                        $output
                    )
                ) {
                    return;
                }

                $this->dropLocation($country, $output);
            }

            $this->populateLocations(
                $countryCode,
                $output
            );
        }

        $message = sprintf(
            '<header>%s</header> <body>%s</body>',
            '[Geo]',
            'Process finished. Please checkout your database'
        );
        $output->writeln($message);
    }

    /**
     * Asks to confirm the location removal
     *
     * @param string          $countryCode  The country code
     * @param DialogHelper    $dialogHelper A dialog helper
     * @param OutputInterface $output       A console output
     *
     * @return bool
     */
    protected function confirmRemoval(
        $countryCode,
        DialogHelper $dialogHelper,
        OutputInterface $output
    ) {
        $message =
            "All locations from $countryCode will be dropped. Continue? (y/n)";

        return $dialogHelper->askConfirmation(
            $output,
            sprintf('<question>%s</question>', $message),
            false
        );
    }

    /**
     * Drops the location and its relations
     *
     * @param LocationInterface $location The location to remove
     * @param OutputInterface   $output   A console output
     */
    protected function dropLocation(
        LocationInterface $location,
        OutputInterface $output
    ) {
        $message = sprintf(
            '<header>[Geo]</header> <body>Dropping country code: %s',
            $location->getCode()
        );
        $output->writeln($message);

        $start = $this
            ->dateTimeFactory
            ->create();

        $this->locationDirector->remove($location);

        $finish = $this
            ->dateTimeFactory
            ->create();

        $elapsed = $finish->diff($start);

        $message = sprintf(
            '<header>[Geo]</header> <body>Dropped in %d min %d sec</body>',
            $elapsed->format('%i'),
            $elapsed->format('%s')
        );
        $output->writeln($message);
    }

    /**
     * Populate the locations for the received country.
     *
     * @param string          $countryCode The country code to import
     * @param OutputInterface $output      A console output
     */
    protected function populateLocations(
        $countryCode,
        OutputInterface $output
    ) {
        $message = sprintf(
            '<header>[Geo]</header> <body>Populating country code: %s',
            $countryCode
        );
        $output->writeln($message);

        $locations = $this
            ->locationPopulator
            ->populate(
                $countryCode,
                $output
            );

        $message =
            '<header>[Geo]</header> <body>Flushing manager started</body>';
        $output->writeln($message);

        $start = $this
            ->dateTimeFactory
            ->create();

        $this
            ->locationDirector
            ->save($locations);

        $finish = $this
            ->dateTimeFactory
            ->create();

        $elapsed = $finish->diff($start);

        $message = sprintf(
            '<header>[Geo]</header> <body>Flushed in %d min %d sec</body>',
            $elapsed->format('%i'),
            $elapsed->format('%s')
        );
        $output->writeln($message);
    }
}
