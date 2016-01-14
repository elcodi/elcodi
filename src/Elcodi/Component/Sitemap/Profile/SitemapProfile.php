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

namespace Elcodi\Component\Sitemap\Profile;

use Elcodi\Component\Sitemap\Dumper\SitemapDumper;

/**
 * Class SitemapProfile.
 */
class SitemapProfile
{
    /**
     * @var array
     *
     * Languages
     */
    private $languages;

    /**
     * @var SitemapDumper[]
     *
     * Array of SitemapDumpers
     */
    private $sitemapDumpers;

    /**
     * Construct.
     *
     * @var array $languages Languages
     */
    public function __construct(array $languages = [])
    {
        $this->languages = $languages;
    }

    /**
     * Add a sitemapDumper.
     *
     * @param SitemapDumper $sitemapDumper Sitemap Dumper
     *
     * @return $this Self object
     */
    public function addSitemapDumper(SitemapDumper $sitemapDumper)
    {
        $this->sitemapDumpers[] = $sitemapDumper;

        return $this;
    }

    /**
     * Build full profile.
     *
     * @param string $basepath Basepath
     *
     * @return $this Self object
     */
    public function dump($basepath)
    {
        foreach ($this->sitemapDumpers as $sitemapDumper) {
            if (is_array($this->languages)) {
                foreach ($this->languages as $language) {
                    $sitemapDumper->dump($basepath, $language);
                }
            } else {
                $sitemapDumper->dump($basepath);
            }
        }

        return $this;
    }
}
