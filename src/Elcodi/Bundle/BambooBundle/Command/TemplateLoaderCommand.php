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

namespace Elcodi\Bundle\BambooBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Bundle\BambooBundle\Services\TemplateLoader;

/**
 * Class TemplateLoaderCommand
 */
class TemplateLoaderCommand extends Command
{
    /**
     * @var TemplateLoader
     *
     * Template loader
     */
    protected $templateLoader;

    /**
     * Constructor
     *
     * @param TemplateLoader $templateLoader Template loader
     */
    public function __construct(TemplateLoader $templateLoader)
    {
        parent::__construct();

        $this->templateLoader = $templateLoader;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:templates:load')
            ->setDescription('Load templates');
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
        $templates = $this
            ->templateLoader
            ->loadTemplates();

        foreach ($templates as $template) {

            $output->writeln('Template @' . $template['bundle'] . ' installed');
        }
    }
}
