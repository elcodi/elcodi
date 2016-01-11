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

namespace Elcodi\Component\Sitemap\Renderer\Interfaces;

use Elcodi\Component\Sitemap\Element\SitemapElement;

/**
 * Interface SitemapRendererInterface.
 */
interface SitemapRendererInterface
{
    /**
     * Given an array of sitemapElements, render the Sitemap.
     *
     * @param SitemapElement[] $sitemapElements Elements
     * @param string           $basepath        Base path
     *
     * @return string Render
     */
    public function render(array $sitemapElements, $basepath);
}
