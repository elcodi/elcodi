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

namespace Elcodi\Component\Core\Command\Abstracts;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * Class AbstractElcodiCommand.
 */
class AbstractElcodiCommand extends Command
{
    /**
     * @var Stopwatch
     *
     * Stopwatch instance
     */
    private $stopwatch;

    /**
     * Start command.
     *
     * @param OutputInterface $output      Output
     * @param bool            $longCommand Show long time message
     *
     * @return $this Self object
     */
    protected function startCommand(
        OutputInterface $output,
        $longCommand = false
    ) {
        $this->configureFormatter($output);
        $this->stopwatch = new Stopwatch();
        $this->startStopWatch('command');
        $output->writeln('');

        $this
            ->printMessage(
                $output,
                $this->getProjectHeader(),
                'Command started at ' . date('r')
            );

        if ($longCommand) {
            $this
                ->printMessage(
                    $output,
                    $this->getProjectHeader(),
                    'This process may take a few minutes. Please, be patient'
                );
        }

        return $this;
    }

    /**
     * Configure formatter with Elcodi specific style.
     *
     * @param OutputInterface $output Output
     *
     * @return $this Self object
     */
    protected function configureFormatter(OutputInterface $output)
    {
        $formatter = $output->getFormatter();
        $formatter->setStyle('header', new OutputFormatterStyle('green'));
        $formatter->setStyle('failheader', new OutputFormatterStyle('red'));
        $formatter->setStyle('body', new OutputFormatterStyle('white'));

        return $this;
    }

    /**
     * Start stopwatch.
     *
     * @param string $eventName Event name
     *
     * @return StopWatchEvent Event
     */
    protected function startStopWatch($eventName)
    {
        return $this
            ->stopwatch
            ->start($eventName);
    }

    /**
     * Print message.
     *
     * @param OutputInterface $output Output
     * @param string          $header Message header
     * @param string          $body   Message body
     *
     * @return $this Self object
     */
    protected function printMessage(
        OutputInterface $output,
        $header,
        $body
    ) {
        $message = sprintf(
            '<header>%s</header> <body>%s</body>',
            '[' . $header . ']',
            $body
        );
        $output->writeln($message);

        return $this;
    }

    /**
     * Print message.
     *
     * @param OutputInterface $output Output
     * @param string          $header Message header
     * @param string          $body   Message body
     *
     * @return $this Self object
     */
    protected function printMessageFail(
        OutputInterface $output,
        $header,
        $body
    ) {
        $message = sprintf(
            '<failheader>%s</failheader> <body>%s</body>',
            '[' . $header . ']',
            $body
        );
        $output->writeln($message);

        return $this;
    }

    /**
     * Finish command.
     *
     * @param OutputInterface $output Output
     *
     * @return $this Self object
     */
    protected function finishCommand(OutputInterface $output)
    {
        $event = $this->stopStopWatch('command');
        $this
            ->printMessage(
                $output,
                $this->getProjectHeader(),
                'Command finished in ' . $event->getDuration() . ' milliseconds'
            )
            ->printMessage(
                $output,
                $this->getProjectHeader(),
                'Max memory used: ' . $event->getMemory() . ' bytes'
            );

        $output->writeln('');

        return $this;
    }

    /**
     * Stop stopwatch.
     *
     * @param string $eventName Event name
     *
     * @return StopwatchEvent Event
     */
    protected function stopStopWatch($eventName)
    {
        return $this
            ->stopwatch
            ->stop($eventName);
    }

    /**
     * Get project header.
     *
     * @return string Get project header
     */
    protected function getProjectHeader()
    {
        return 'elcodi';
    }
}
