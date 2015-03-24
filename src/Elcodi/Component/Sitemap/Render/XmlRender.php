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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Sitemap\Render;

use Elcodi\Component\Sitemap\Profile\Interfaces\SitemapProfileInterface;
use Elcodi\Component\Sitemap\Render\Interfaces\SitemapRenderInterface;

/**
 * Class XmlRender
 */
class XmlRender implements SitemapRenderInterface
{
    /**
     * Render a sitemap profile
     *
     * @param SitemapProfileInterface $sitemapProfile Sitemap profile
     *
     * @return string Rendered XML
     */
    public function render(SitemapProfileInterface $sitemapProfile)
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $data .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($sitemapProfile->getEntityLoaders() as $entityLoader) {
            $transformer = $entityLoader->getTransformer();
            foreach ($entityLoader->load() as $entity) {
                $data .= '    <url>' . PHP_EOL;
                $data .= '        <loc>' . $transformer->getLoc($entity) . '</loc>' . PHP_EOL;
                $data .= '        <lastmod>' . $transformer->getLastMod($entity) . '</lastmod>' . PHP_EOL;
                $data .= '        <changefreq>' . $transformer->getChangeFreq($entity) . '</changefreq>' . PHP_EOL;
                $data .= '        <priority>' . $transformer->getPriority($entity) . '</priority>' . PHP_EOL;
                $data .= '    </url>' . PHP_EOL;
            }
        }

        $data .= '</urlset>' . PHP_EOL;

        return $data;
    }
}
