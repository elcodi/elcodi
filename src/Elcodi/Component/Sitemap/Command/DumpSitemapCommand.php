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

namespace Elcodi\Component\Sitemap\Command;

use Elcodi\Component\Sitemap\Dumper\SitemapDumper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Sitemap\Dumper\SitemapDumperChain;

/**
 * Class DumpSitemapCommand
 */
class DumpSitemapCommand extends Command
{
    /**
     * @var SitemapDumperChain
     *
     * Dumper
     */
    protected $sitemapDumperChain;

    /**
     * Construct
     *
     * @param SitemapDumperChain $sitemapDumperChain Dumper chain
     */
    public function __construct(SitemapDumperChain $sitemapDumperChain)
    {
        $this->sitemapDumperChain = $sitemapDumperChain;

        parent::__construct();
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:sitemap:dump')
            ->setDescription('Dumps sitemap for given profile name')
            ->addArgument('profileName', InputArgument::REQUIRED, 'Profile name');
    }

    /**
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return integer|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $profileName = $input->getArgument('profileName');
        $dumpers = $this
            ->sitemapDumperChain
            ->getSitemapDumpers();

        /** @var SitemapDumper $dumper */
        $dumper = array_filter($dumpers, function($dumper) use ($profileName) {
            /** @var SitemapDumper $dumper */
            return $dumper->getSitemapProfile()->getName() === $profileName;
        });

        $dumper->dump();

        $output->writeln(
            '<header>[Sitemap]</header> <body>Sitemap ' .
            $profileName .
            ' built in . ' . $dumper->getSitemapProfile()->getPath() . ' </body>'
        );
    }
}
