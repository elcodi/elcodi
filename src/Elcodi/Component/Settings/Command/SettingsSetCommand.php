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
 * Class SettingsSetCommand
 */
class SettingsSetCommand extends Command
{
    /**
     * @var ConfigurationManager
     *
     * Configuration manager
     */
    protected $configurationManager;

    /**
     * Constructor
     *
     * @param ConfigurationManager $configurationManager Settings manager
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
            ->setName('elcodi:settings:set')
            ->setDescription('Set an specific settings value with a value')
            ->addArgument(
                'identifier',
                InputArgument::REQUIRED,
                'Settings identifier'
            )
            ->addArgument(
                'value',
                InputArgument::REQUIRED,
                'Settings name in a json_encode mode'
            );
    }

    /**
     * This command saves a settings value
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $settingsIdentifier = $input->getArgument('identifier');
        $settingsValue = json_decode($input->getArgument('value'), true);

        $this
            ->settingsManager
            ->set(
                $settingsIdentifier,
                $settingsValue
            );

        $formatter = $this->getHelper('formatter');
        $formattedLine = $formatter->formatSection(
            'OK',
            'Saved configuration "' . $settingsIdentifier . '"'
        );

        $output->writeln($formattedLine);
    }
}
