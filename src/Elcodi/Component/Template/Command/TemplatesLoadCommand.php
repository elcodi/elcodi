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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Template\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Template\Services\TemplateManager;

/**
 * Class TemplatesLoadCommand
 */
class TemplatesLoadCommand extends Command
{
    /**
     * @var TemplateManager
     *
     * Template manager
     */
    protected $templateManager;

    /**
     * Constructor
     *
     * @param TemplateManager $templateManager Template manager
     */
    public function __construct(TemplateManager $templateManager)
    {
        parent::__construct();

        $this->templateManager = $templateManager;
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
     * This command loads all the templates installed
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter');
        $templates = $this
            ->templateManager
            ->loadTemplates();

        foreach ($templates as $template) {
            $formattedLine = $formatter->formatSection(
                'OK',
                'Template "'.$template['bundle'].'" installed'
            );

            $output->writeln($formattedLine);
        }
    }
}
