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

namespace Elcodi\Component\Sitemap\Transformer\Interfaces;

/**
 * Interface SitemapTransformerInterface
 */
interface SitemapTransformerInterface
{
    /**
     * Get url given an entity
     *
     * @param Object $entity Entity
     *
     * @return string url
     */
    public function getLoc($entity);

    /**
     * Get last mod
     *
     * @param Object $entity Entity
     *
     * @return string Last mod value
     */
    public function getLastMod($entity);

    /**
     * Get Change freq
     *
     * @param Object $entity Entity
     *
     * @return string Change freq value
     */
    public function getChangeFreq($entity);

    /**
     * Get Priority
     *
     * @param Object $entity Entity
     *
     * @return string Priority value
     */
    public function getPriority($entity);
}
