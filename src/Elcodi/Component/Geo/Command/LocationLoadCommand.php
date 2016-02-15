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
use Elcodi\Component\Geo\Services\LocationLoader;

/**
 * Class LocationLoadCommand.
 */
class LocationLoadCommand extends AbstractLocationCommand
{
    /**
     * @var LocationLoader
     *
     * Location Loader
     */
    private $locationLoader;

    /**
     * Construct method.
     *
     * @param ObjectDirector $locationDirector Location director
     * @param LocationLoader $locationLoader   Location Loader
     */
    public function __construct(
        ObjectDirector $locationDirector,
        LocationLoader $locationLoader
    ) {
        parent::__construct($locationDirector);

        $this->locationLoader = $locationLoader;
    }

    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:locations:load')
            ->setDescription('Load a set of countries from an external repository');

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
        $this->startCommand($output);
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
                    ->locationLoader
                    ->loadCountry($countryCode);

                $this
                    ->printMessage(
                        $output,
                        'Geo',
                        'Country ' . $countryCode . ' loaded from repository'
                    );
            } catch (Exception $exception) {
                $this
                    ->printMessageFail(
                        $output,
                        'Geo',
                        'Country ' . $countryCode . ' cannot be loaded from repository'
                    );
            }
        }

        $this->finishCommand($output);
    }
}
