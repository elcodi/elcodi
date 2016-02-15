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

namespace Elcodi\Component\Geo\Command;

use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Geo\Command\Abstracts\AbstractLocationCommand;
use Elcodi\Component\Geo\Services\LocationPopulator;

/**
 * Class LocationPopulateCommand.
 */
class LocationPopulateCommand extends AbstractLocationCommand
{
    /**
     * @var LocationPopulator
     *
     * Location Populator
     */
    private $locationPopulator;

    /**
     * Construct method.
     *
     * @param ObjectDirector    $locationDirector  Location director
     * @param LocationPopulator $locationPopulator Location Populator
     */
    public function __construct(
        ObjectDirector $locationDirector,
        LocationPopulator $locationPopulator
    ) {
        parent::__construct($locationDirector);

        $this->locationPopulator = $locationPopulator;
    }

    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:locations:populate')
            ->setDescription('Populates a set of countries');

        parent::configure();
    }

    /**
     * This command loads all the locations for the received country.
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->startCommand($output, true);
        $countries = $this->getCountriesFromInput($input);

        foreach ($countries as $countryCode) {
            $countryCode = strtoupper($countryCode);
            if ($input->getOption('drop-if-exists')) {
                $this
                    ->deleteCountry(
                        $input,
                        $output,
                        $countryCode
                    );
            }

            try {
                $this
                    ->locationPopulator
                    ->populateCountry($countryCode);

                $this
                    ->printMessage(
                        $output,
                        'Geo',
                        'Country ' . $countryCode . ' populated from source'
                    );
            } catch (Exception $exception) {
                $this
                    ->printMessageFail(
                        $output,
                        'Geo',
                        'Country ' . $countryCode . ' cannot be populated from source'
                    );
            }
        }

        $this->finishCommand($output);
    }
}
