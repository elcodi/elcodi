<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\Template\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Configuration\Services\ConfigurationManager;

/**
 * Class TemplatesEnableCommand
 */
class TemplatesEnableCommand extends Command
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
     * @param ConfigurationManager $configurationManager Configuration manager
     */
    public function __construct(ConfigurationManager $configurationManager)
    {
        parent::__construct();

        $this->configurationManager = $configurationManager;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:templates:enable')
            ->setDescription('Enable template')
            ->addArgument(
                'template',
                InputArgument::REQUIRED,
                'Template name'
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
     *
     * @throws Exception Template nof found
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $templateName = $input->getArgument('template');
        $templates = $this->configurationManager->get('store.templates');
        $templateFound = array_reduce(
            $templates,
            function ($alreadyFound, $template) use ($templateName) {
                return $alreadyFound || ($template['bundle'] == $templateName);
            },
            false);

        if (!$templateFound) {

            throw new Exception(sprintf('Template %s not found', $templateName));
        }

        $this
            ->configurationManager
            ->set('store.template', $templateName);

        $formatter = $this->getHelper('formatter');
        $formattedLine = $formatter->formatSection(
            'OK',
            'Template "' . $templateName . '" enabled'
        );

        $output->writeln($formattedLine);
    }
}
