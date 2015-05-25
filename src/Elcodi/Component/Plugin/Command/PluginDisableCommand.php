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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Plugin\Command\Abstracts\AbstractPluginEnableCommand;

/**
 * Class PluginDisableCommand
 */
class PluginDisableCommand extends AbstractPluginEnableCommand
{
    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:plugin:disable')
            ->setAliases([
                'plugin:disable',
            ])
            ->setDescription('Disable a plugin')
            ->addArgument(
                'hash',
                InputArgument::REQUIRED,
                'Plugin hash'
            );
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
        $pluginHash = $input->getArgument('hash');
        $plugin = $this
            ->pluginRepository
            ->findOneBy([
                'hash' => $pluginHash,
            ]);

        if (!($plugin instanceof \Elcodi\Component\Plugin\Entity\Plugin)) {
            $output->writeln($formatterHelper->formatSection(
                'FAIL',
                'Plugin with hash "' . $pluginHash . '" not found',
                'error'
            ));

            return null;
        }

        $plugin->disable();
        $this
            ->pluginObjectManager
            ->flush($plugin);
        $output->writeln($formatterHelper->formatSection(
            'OK',
            'Plugin with hash "' . $pluginHash . '" disabled'
        ));
    }
}
