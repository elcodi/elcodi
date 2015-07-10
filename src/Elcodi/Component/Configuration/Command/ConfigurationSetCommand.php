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

namespace Elcodi\Component\Configuration\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Configuration\Command\Abstracts\AbstractConfigurationCommand;

/**
 * Class ConfigurationSetCommand
 */
class ConfigurationSetCommand extends AbstractConfigurationCommand
{
    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:configuration:set')
            ->setDescription('Set an specific configuration value with a value')
            ->addArgument(
                'value',
                InputArgument::REQUIRED,
                'Configuration name using json format'
            );

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
        $configurationValue = json_decode($input->getArgument('value'), true);

        $this
            ->configurationManager
            ->set(
                $configurationIdentifier,
                $configurationValue
            );

        $this->printMessage(
            $output,
            'Configuration',
            'Saved configuration "' . $configurationIdentifier . '"'
        );

        $this->finishCommand($output);
    }
}
