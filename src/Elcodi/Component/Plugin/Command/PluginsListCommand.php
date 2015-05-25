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

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Repository\PluginRepository;

/**
 * Class PluginsListCommand
 */
class PluginsListCommand extends Command
{
    /**
     * @var PluginRepository
     *
     * Plugin repository
     */
    protected $pluginRepository;

    /**
     * Constructor
     *
     * @param PluginRepository $pluginRepository Plugin repository
     */
    public function __construct(PluginRepository $pluginRepository)
    {
        parent::__construct();

        $this->pluginRepository = $pluginRepository;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:plugin:list')
            ->setAliases([
                'plugin:list',
            ])
            ->setDescription('Lists all available plugins');
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
        $formatterHelper = $this->getHelper('formatter');
        $plugins = $this
            ->pluginRepository
            ->findAll();

        /**
         * @var Plugin $plugin
         */
        foreach ($plugins as $plugin) {
            $output->writeln($formatterHelper->formatSection(
                'Plugin',
                $plugin->getNamespace() . ' - [Hash : ' . $plugin->getHash() . ']'
            ));
        }
    }
}
