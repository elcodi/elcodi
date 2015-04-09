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

namespace Elcodi\Component\Sitemap\Dumper;

use Elcodi\Component\Sitemap\Builder\SitemapBuilder;
use Elcodi\Component\Sitemap\Dumper\Interfaces\SitemapDumperInterface;

/**
 * Class SitemapDumper
 */
class SitemapDumper
{
    /**
     * @var SitemapBuilder
     *
     * Sitemap Builder
     */
    protected $sitemapBuilder;

    /**
     * @var SitemapDumperInterface
     *
     * Sitemap Dumper
     */
    protected $sitemapDumper;

    /**
     * @var string
     *
     * Path
     */
    protected $path;

    /**
     * @param SitemapBuilder         $sitemapBuilder Sitemap Builder
     * @param SitemapDumperInterface $sitemapDumper  Sitemap Dumper
     * @param string                 $path           Path
     */
    public function __construct(
        SitemapBuilder $sitemapBuilder,
        SitemapDumperInterface $sitemapDumper,
        $path
    ) {
        $this->sitemapBuilder = $sitemapBuilder;
        $this->sitemapDumper = $sitemapDumper;
        $this->path = $path;
    }

    /**
     * Dump builder using a dumper
     *
     * @param string|null $language Language
     */
    public function dump($language = null)
    {
        $sitemapData = $this
            ->sitemapBuilder
            ->build($language);

        $path = $this->resolvePathWithLanguage(
            $this->path,
            $language
        );

        $this
            ->sitemapDumper
            ->dump($path, $sitemapData);
    }

    /**
     * Given a language and a path, resolve this path
     *
     * @param string $path     Path
     * @param string $language Language
     *
     * @return string Path resolved
     */
    protected function resolvePathWithLanguage($path, $language)
    {
        return str_replace('{_locale}', $language, $path);
    }
}
