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
 * Class ConfigurationGetCommand
 */
class SettingsGetCommand extends Command
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
     * @param SettingsManager $settingsManager Settings manager
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
            ->setName('elcodi:settings:get')
            ->setDescription('Get an specific json_encoded settings value.')
            ->addArgument(
                'identifier',
                InputArgument::REQUIRED,
                'Settings identifier'
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

        $settingsValue = json_encode($this
            ->settingsManager
            ->get($settingsIdentifier));

        $formatter = $this->getHelper('formatter');
        $formattedLine = $formatter->formatSection(
            $settingsIdentifier,
            $settingsValue
        );

        $output->writeln($formattedLine);
    }
}
