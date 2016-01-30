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

namespace Elcodi\Component\Sitemap\Renderer;

use Elcodi\Component\Sitemap\Element\SitemapElement;
use Elcodi\Component\Sitemap\Renderer\Interfaces\SitemapRendererInterface;

/**
 * Class XmlRenderer.
 */
class XmlRenderer implements SitemapRendererInterface
{
    /**
     * Given an array of sitemapElements, render the Sitemap.
     *
     * @param SitemapElement[] $sitemapElements Elements
     * @param string           $basepath        Base path
     *
     * @return string Render
     */
    public function render(array $sitemapElements, $basepath)
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $data .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($sitemapElements as $sitemapElement) {
            $data .= '    <url>' . PHP_EOL;
            $data .= '        <loc>' . $basepath . $sitemapElement->getLocation() . '</loc>' . PHP_EOL;

            $lastModification = $sitemapElement->getLastModification();
            if (null !== $lastModification) {
                $data .= '        <lastmod>' . $lastModification . '</lastmod>' . PHP_EOL;
            }

            $changeFrequency = $sitemapElement->getChangeFrequency();
            if (null !== $changeFrequency) {
                $data .= '        <changefreq>' . $changeFrequency . '</changefreq>' . PHP_EOL;
            }

            $priority = $sitemapElement->getPriority();
            if (null !== $priority) {
                $data .= '        <priority>' . $priority . '</priority>' . PHP_EOL;
            }

            $data .= '    </url>' . PHP_EOL;
        }

        $data .= '</urlset>' . PHP_EOL;

        return $data;
    }
}
