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

namespace Elcodi\Component\Settings\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Settings\Services\SettingsManager;

/**
 * Class SettingsDeleteCommand
 */
class SSettingsDeleteCommand extends Command
{
    /**
     * @var SettingsManager
     *
     * Settings manager
     */
    protected $settingsManager;

    /**
     * Constructor
     *
     * @param ConfigurationManager $configurationManager Configuration manager
     */
    public function __construct(SettingsManager $settingsManager)
    {
        parent::__construct();

        $this->settingsManager = $settingsManager;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:settings:delete')
            ->setDescription('Deletes a specific settings value')
            ->addArgument(
                'identifier',
                InputArgument::REQUIRED,
                'Settings identifier'
            );
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
        $configurationIdentifier = $input->getArgument('identifier');

        $this
            ->settingsManager
            ->delete(
                $configurationIdentifier
            );

        $formatter = $this->getHelper('formatter');
        $formattedLine = $formatter->formatSection(
            'OK',
            'Deleted settings "' . $configurationIdentifier . '"'
        );

        $output->writeln($formattedLine);
    }
}
