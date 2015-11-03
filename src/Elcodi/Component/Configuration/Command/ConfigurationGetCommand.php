<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Configuration\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Configuration\Command\Abstracts\AbstractConfigurationCommand;

/**
 * Class ConfigurationGetCommand
 */
class ConfigurationGetCommand extends AbstractConfigurationCommand
{
    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:configuration:get')
            ->setDescription('Get an specific json_encoded configuration value.');

        parent::configure();
    }

    /**
     * This command saves a configuration value
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->startCommand($output);

        $configurationIdentifier = $input->getArgument('identifier');
        $configurationValue = json_encode($this
            ->configurationManager
            ->get($configurationIdentifier));

        $this->printMessage(
            $output,
            'Configuration',
            $configurationIdentifier . ' : "' . $configurationValue . '"'
        );

        $this->finishCommand($output);
    }
}
