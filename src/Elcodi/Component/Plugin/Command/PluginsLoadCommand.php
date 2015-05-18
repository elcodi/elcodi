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

namespace Elcodi\Component\Plugin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Plugin\Services\PluginManager;

/**
 * Class PluginsLoadCommand
 */
class PluginsLoadCommand extends Command
{
    /**
     * @var PluginManager
     *
     * Plugin manager
     */
    protected $pluginManager;

    /**
     * Constructor
     *
     * @param PluginManager $pluginManager Plugin manager
     */
    public function __construct(PluginManager $pluginManager)
    {
        parent::__construct();

        $this->pluginManager = $pluginManager;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:plugins:load')
            ->setDescription('Load plugins');
    }

    /**
     * This command loads all the exchange rates from base_currency to all available
     * currencies
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter');
        $plugins = $this
            ->pluginManager
            ->loadPlugins();

        foreach ($plugins as $plugin) {
            $formattedLine = $formatter->formatSection(
                'OK',
                'Plugin "' . $plugin->getNamespace() . '" installed'
            );

            $output->writeln($formattedLine);
        }
    }
}
