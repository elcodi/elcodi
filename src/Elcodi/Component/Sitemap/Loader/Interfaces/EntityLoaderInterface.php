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

namespace Elcodi\Component\Sitemap\Loader\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\Component\Sitemap\Transformer\Interfaces\SitemapTransformerInterface;

/**
 * Interface EntityLoaderInterface
 */
interface EntityLoaderInterface
{
    /**
     * Load all the entities
     *
     * @return ArrayCollection Entities
     */
    public function load();

    /**
     * Get Transformer
     *
     * @return SitemapTransformerInterface Transformer
     */
    public function getTransformer();
}
