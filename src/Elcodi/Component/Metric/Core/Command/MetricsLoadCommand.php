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

namespace Elcodi\Component\Metric\Core\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;
use Elcodi\Component\Metric\Core\Services\MetricLoader;

/**
 * Class MetricsLoadCommand.
 */
class MetricsLoadCommand extends AbstractElcodiCommand
{
    /**
     * @var MetricLoader
     *
     * Metric loader
     */
    private $metricLoader;

    /**
     * Construct.
     *
     * @param MetricLoader $metricLoader Metric loader
     */
    public function __construct(MetricLoader $metricLoader)
    {
        parent::__construct();

        $this->metricLoader = $metricLoader;
    }

    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:metrics:load')
            ->setDescription('Load metrics from database')
            ->addArgument(
                'days',
                InputArgument::REQUIRED,
                'Number of days you want to load'
            );
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

        $days = $input->getArgument('days');
        $entries = $this
            ->metricLoader
            ->loadEntriesFromLastDays($days);

        $nbEntries = count($entries);
        $this->printMessage(
            $output,
            'Metric',
            'Added ' . $nbEntries . ' entries from last ' . $days . ' days'
        );

        $this->finishCommand($output);
    }
}
