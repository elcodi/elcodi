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

namespace Elcodi\Component\Sitemap\Builder;

use Elcodi\Component\Sitemap\Element\Interfaces\SitemapElementGeneratorInterface;
use Elcodi\Component\Sitemap\Renderer\Interfaces\SitemapRendererInterface;

/**
 * Class SitemapBuilder.
 */
class SitemapBuilder
{
    /**
     * @var SitemapElementGeneratorInterface[]
     *
     * sitemapElementGenerators
     */
    private $sitemapElementGenerators;

    /**
     * @var SitemapRendererInterface
     *
     * sitemapRenderer
     */
    private $sitemapRenderer;

    /**
     * Construct.
     *
     * @param SitemapRendererInterface $sitemapRenderer sitemapRenderer
     */
    public function __construct(SitemapRendererInterface $sitemapRenderer)
    {
        $this->sitemapRenderer = $sitemapRenderer;
    }

    /**
     * Add a new SitemapElement Generator.
     *
     * @param SitemapElementGeneratorInterface $sitemapElementGenerator sitemapRenderer
     *
     * @return $this
     */
    public function addSitemapElementGenerator(
        SitemapElementGeneratorInterface $sitemapElementGenerator
    ) {
        $this->sitemapElementGenerators[] = $sitemapElementGenerator;

        return $this;
    }

    /**
     * Build sitemap builder.
     *
     * @param string      $basepath Base path
     * @param string|null $language Language
     *
     * @return string Generated data
     */
    public function build($basepath, $language = null)
    {
        $sitemapElements = [];

        foreach ($this->sitemapElementGenerators as $sitemapElementGenerator) {
            $sitemapElements = array_merge(
                $sitemapElements,
                $sitemapElementGenerator->generateElements($language)
            );
        }

        $data = $this
            ->sitemapRenderer
            ->render($sitemapElements, $basepath);

        return $data;
    }
}
