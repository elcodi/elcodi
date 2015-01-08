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
use Elcodi\Component\Sitemap\EventDispatcher\SitemapEventDispatcher;
use Elcodi\Component\Sitemap\Profile\Interfaces\SitemapProfileInterface;
use Elcodi\Component\Sitemap\Render\Interfaces\SitemapRenderInterface;

/**
 * Class SitemapDumper
 */
class SitemapDumper implements SitemapDumperInterface
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
     * @var SitemapEventDispatcher
     *
     * Event dispatcher
     */
    protected $eventDispatcher;

    /**
     * Construct
     *
     * @param SitemapRenderInterface  $sitemapRender   Render
     * @param SitemapProfileInterface $sitemapProfile  Profile
     * @param SitemapEventDispatcher  $eventDispatcher Event dispatcher
     */
    public function __construct(
        SitemapRenderInterface $sitemapRender,
        SitemapProfileInterface $sitemapProfile,
        SitemapEventDispatcher $eventDispatcher
    )
    {
        $this->sitemapRender = $sitemapRender;
        $this->sitemapProfile = $sitemapProfile;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get SitemapProfile
     *
     * @return SitemapProfileInterface SitemapProfile
     */
    public function getSitemapProfile()
    {
        return $this->sitemapProfile;
    }

    /**
     * Get SitemapRender
     *
     * @return SitemapRenderInterface SitemapRender
     */
    public function getSitemapRender()
    {
        return $this->sitemapRender;
    }

    /**
     * Dump all the sitemap content into the desired render
     *
     * @return $this self Object
     */
    public function dump()
    {
        $data = $this
            ->sitemapRender
            ->render($this->sitemapProfile);

        file_put_contents(
            $this->sitemapProfile->getPath(),
            $data
        );

        $this
            ->eventDispatcher
            ->dispatchSitemapGeneratedEvent(
                $this->sitemapProfile->getPath(),
                $data
            );
    }
}
