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

namespace Elcodi\Component\Plugin\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;
use Elcodi\Component\Plugin\Services\PluginManager;

/**
 * Class PluginsLoadCommand.
 */
class PluginsLoadCommand extends AbstractElcodiCommand
{
    /**
     * @var PluginManager
     *
     * Plugin manager
     */
    protected $pluginManager;

    /**
     * Constructor.
     *
     * @param PluginManager $pluginManager Plugin manager
     */
    public function __construct(PluginManager $pluginManager)
    {
        parent::__construct();

        $this->pluginManager = $pluginManager;
    }

    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:plugins:load')
            ->setDescription('Load plugins')
            ->setAliases([
                'plugin:load',
            ]);
    }

    /**
     * This command loads all the exchange rates from base_currency to all available
     * currencies.
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->startCommand($output);
        $plugins = $this
            ->pluginManager
            ->loadPlugins();

        foreach ($plugins as $plugin) {
            $this->printMessage(
                $output,
                'Plugin',
                'Plugin "' . $plugin->getNamespace() . '" installed'
            );
        }

        $this->finishCommand($output);
    }
}
