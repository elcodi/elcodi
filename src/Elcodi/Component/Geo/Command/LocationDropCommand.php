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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Geo\Command\Abstracts\AbstractLocationCommand;

/**
 * Class LocationDropCommand.
 */
class LocationDropCommand extends AbstractLocationCommand
{
    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:locations:drop')
            ->setDescription('Drop a set of countries');

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
            $this
                ->deleteCountry(
                    $input,
                    $output,
                    $countryCode
                );
        }

        $this->finishCommand($output);
    }
}
