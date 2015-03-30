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

namespace Elcodi\Component\Sitemap\Profile\Interfaces;

use Elcodi\Component\Sitemap\Loader\Interfaces\EntityLoaderInterface;

/**
 * Interface SitemapProfileInterface
 */
interface SitemapProfileInterface
{
    /**
     * Get Entity loaders
     *
     * @return EntityLoaderInterface[] Entity loaders
     */
    public function getEntityLoaders();

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Get Path
     *
     * @return string Path
     */
    public function getPath();
}
