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

namespace Elcodi\Component\Sitemap\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;

/**
 * Class SitemapDumpCommand.
 */
class SitemapDumpCommand extends AbstractElcodiCommand
{
    /**
     * @var ContainerInterface
     *
     * Container
     */
    private $container;

    /**
     * Construct.
     *
     * @param ContainerInterface $container Container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct();
    }

    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:sitemap:dump')
            ->setDescription('Dump a sitemap')
            ->addArgument(
                'builder-name',
                InputArgument::REQUIRED,
                'Builder name'
            )
            ->addArgument(
                'basepath',
                InputArgument::REQUIRED,
                'Base path'
            )
            ->addOption(
                'language',
                null,
                InputOption::VALUE_OPTIONAL,
                'Language'
            );
    }

    /**
     * Get the dumper name from the input object and tries to dump all sitemap
     * content.
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->startCommand($output);

        $builderName = $input->getArgument('builder-name');
        $basepath = $input->getArgument('basepath');
        $language = $input->getOption('language');
        $sitemapDumper = $this
            ->container
            ->get('elcodi.sitemap_dumper.' . $builderName);

        $sitemapDumper->dump(
            $basepath,
            $language
        );

        $this->finishCommand($output);
    }
}
