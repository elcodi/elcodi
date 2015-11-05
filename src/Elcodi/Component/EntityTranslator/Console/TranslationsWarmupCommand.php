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

namespace Elcodi\Component\EntityTranslator\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;
use Elcodi\Component\EntityTranslator\EventDispatcher\EntityTranslatorEventDispatcher;

/**
 * Class TranslationsWarmupCommand
 */
class TranslationsWarmupCommand extends AbstractElcodiCommand
{
    /**
     * @var EntityTranslatorEventDispatcher
     *
     * Entity translator event dispatcher
     */
    private $entityTranslationEventDispatcher;

    /**
     * Constructor
     *
     * @param EntityTranslatorEventDispatcher $entityTranslationEventDispatcher Entity translator event dispatcher
     */
    public function __construct(EntityTranslatorEventDispatcher $entityTranslationEventDispatcher)
    {
        parent::__construct();

        $this->entityTranslationEventDispatcher = $entityTranslationEventDispatcher;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:translations:warmup')
            ->setDescription('Warmup all translations');
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
        $this->startCommand($output);

        $this
            ->entityTranslationEventDispatcher
            ->dispatchTranslatorWarmUp();

        $this->finishCommand($output);
    }
}
