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

namespace Elcodi\Component\Sitemap\Dumper\Interfaces;
 
/**
 * Interface SitemapDumperInterface
 */
interface SitemapDumperInterface
{
    /**
     * Dump all the sitemap content into the desired render
     *
     * @return $this self Object
     */
    public function dump();
}
 