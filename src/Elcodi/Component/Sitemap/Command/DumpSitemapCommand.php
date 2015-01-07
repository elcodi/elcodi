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

namespace Elcodi\Component\Sitemap\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Sitemap\Dumper\SitemapDumper;

/**
 * Class DumpSitemapCommand
 */
class DumpSitemapCommand extends Command
{
    /**
     * @var SitemapDumper
     *
     * Dumper
     */
    protected $sitemapDumper;

    /**
     * Construct
     *
     * @param SitemapDumper $sitemapDumper Dumper
     */
    public function __construct(SitemapDumper $sitemapDumper)
    {
        $this->sitemapDumper = $sitemapDumper;

        parent::__construct();
    }

    /**
     * configure
     */
    protected function configure()
    {
        $sitemapProfileName = $this->getSitemapProfileName();

        $this
            ->setName('elcodi:sitemap:' . $sitemapProfileName . ':dump')
            ->setDescription('Dumps sitemap ' . $sitemapProfileName);
    }

    /**
     * This command loads all the exchange rates from base_currency to all available
     * currencies
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this
            ->sitemapDumper
            ->dump();

        $output->writeln(
            '<header>[Sitemap]</header> <body>Sitemap ' .
            $this->getSitemapProfileName() .
            ' built in . ' . $this->getSitemapProfilePath() . ' </body>'
        );
    }

    /**
     * Get sitemap profile name
     *
     * @return string Sitemap profile name
     */
    protected function getSitemapProfileName()
    {
        return $this
            ->sitemapDumper
            ->getSitemapProfile()
            ->getName();
    }

    /**
     * Get sitemap profile path
     *
     * @return string Sitemap profile path
     */
    protected function getSitemapProfilePath()
    {
        return $this
            ->sitemapDumper
            ->getSitemapProfile()
            ->getPath();
    }
}
