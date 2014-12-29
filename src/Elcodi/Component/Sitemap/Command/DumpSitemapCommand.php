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

use Elcodi\Component\Sitemap\Profile\Interfaces\SitemapProfileInterface;
use Elcodi\Component\Sitemap\Render\Interfaces\SitemapRenderInterface;

/**
 * Class DumpSitemapCommand
 */
class DumpSitemapCommand extends Command
{
    /**
     * @var SitemapRenderInterface
     *
     * Render
     */
    protected $sitemapRender;

    /**
     * @var SitemapProfileInterface
     *
     * Profile
     */
    protected $sitemapProfile;

    /**
     * Construct
     *
     * @param SitemapRenderInterface  $sitemapRender  Render
     * @param SitemapProfileInterface $sitemapProfile Profile
     */
    public function __construct(
        SitemapRenderInterface $sitemapRender,
        SitemapProfileInterface $sitemapProfile
    )
    {
        $this->sitemapRender = $sitemapRender;
        $this->sitemapProfile = $sitemapProfile;

        parent::__construct();
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:sitemap:' . $this->sitemapProfile->getName() . ':dump')
            ->setDescription('Dumps sitemap ' . $this->sitemapProfile->getName());
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
        $data = $this
            ->sitemapRender
            ->render($this->sitemapProfile);

        file_put_contents(
            $this->sitemapProfile->getPath(),
            $data
        );

        $output->writeln('<header>[Sitemap]</header> <body>Sitemap file built.</body>');
    }
}
