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
 
namespace Elcodi\Component\Sitemap\Dumper;

use Elcodi\Component\Sitemap\Dumper\Interfaces\SitemapDumperInterface;

/**
 * Class SitemapDumperChain
 */
class SitemapDumperChain
{
    /**
     * @var SitemapDumperInterface[]
     *
     * Chain of SitemapDumper instances
     */
    protected $sitemapDumpers;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->sitemapDumpers = [];
    }

    /**
     * Add sitemapdumper
     *
     * @var SitemapDumperInterface $sitemapDumper Sitemap dumper
     *
     * @return $this self Object
     */
    public function addSitemapDumper(SitemapDumperInterface $sitemapDumper)
    {
        $this->sitemapDumpers[] = $sitemapDumper;

        return $this;
    }

    /**
     * Get sitemap dumpers
     *
     * @return SitemapDumperInterface[] SitemapDumpers
     */
    public function getSitemapDumpers()
    {
        return $this->sitemapDumpers;
    }
}
 