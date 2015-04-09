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

namespace Elcodi\Component\Sitemap\Element;

use Elcodi\Component\Sitemap\Element\Interfaces\SitemapElementGeneratorInterface;
use Elcodi\Component\Sitemap\Factory\SitemapElementFactory;
use Elcodi\Component\Sitemap\Transformer\Interfaces\SitemapTransformerInterface;

/**
 * Class StaticSitemapElementGenerator
 */
class StaticSitemapElementGenerator implements SitemapElementGeneratorInterface
{
    /**
     * @var SitemapElementFactory
     *
     * SitemapElement factory
     */
    protected $sitemapElementFactory;

    /**
     * @var SitemapTransformerInterface
     *
     * Sitemap transformer
     */
    protected $transformer;

    /**
     * @var string
     *
     * Route
     */
    protected $route;

    /**
     * @var string
     *
     * Change frequency
     */
    protected $changeFrequency;

    /**
     * @var string
     *
     * Priority
     */
    protected $priority;

    /**
     * Construct method
     *
     * @param SitemapElementFactory       $sitemapElementFactory SitemapElement Factory
     * @param SitemapTransformerInterface $transformer           Transformer
     * @param string                      $route                 Route
     * @param string|null                 $changeFrequency       Change frequency
     * @param string|null                 $priority              Priority
     */
    public function __construct(
        SitemapElementFactory $sitemapElementFactory,
        SitemapTransformerInterface $transformer,
        $route,
        $changeFrequency = null,
        $priority = null
    ) {
        $this->sitemapElementFactory = $sitemapElementFactory;
        $this->transformer = $transformer;
        $this->route = $route;
        $this->changeFrequency = $changeFrequency;
        $this->priority = $priority;
    }

    /**
     * Generate desired elements
     *
     * @param string|null $language Language
     *
     * @return array Elements generated
     */
    public function generateElements($language = null)
    {
        $transformer = $this->transformer;

        $sitemapElement = $this
            ->sitemapElementFactory
            ->create(
                $transformer->getLoc($this->route, $language),
                null,
                $this->changeFrequency,
                $this->priority
            );

        return [$sitemapElement];
    }
}
