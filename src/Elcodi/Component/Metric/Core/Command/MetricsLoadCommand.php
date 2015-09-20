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

namespace Elcodi\Component\Metric\Core\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Metric\Core\Services\MetricLoader;

/**
 * Class MetricsLoadCommand
 */
class MetricsLoadCommand extends Command
{
    /**
     * @var MetricLoader
     *
     * Metric loader
     */
    private $metricLoader;

    /**
     * Construct
     *
     * @param MetricLoader $metricLoader Metric loader
     */
    public function __construct(MetricLoader $metricLoader)
    {
        parent::__construct();

        $this->metricLoader = $metricLoader;
    }

    /**
     * configure
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
     * currencies
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return integer|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $days = $input->getArgument('days');

        $formatter = $output->getFormatter();
        $formatter->setStyle('header', new OutputFormatterStyle('green'));
        $formatter->setStyle('body', new OutputFormatterStyle('white'));

        $entries = $this
            ->metricLoader
            ->loadEntriesFromLastDays($days);

        $nbEntries = count($entries);
        $message = sprintf(
            '<header>%s</header> <body>%s</body>',
            '[Metric]',
            'Process finished. Added ' . $nbEntries . ' entries from last ' . $days . ' days'
        );
        $output->writeln($message);
    }
}
