<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity\Interfaces;

/**
 * Class MetaDataInterface
 */
interface MetaDataInterface
{
    /**
     * Set meta description
     *
     * @param string $metaDescription
     *
     * @return Object self Object
     */
    public function setMetaDescription($metaDescription);

    /**
     * Get meta description
     *
     * @return string Meta description
     */
    public function getMetaDescription();

    /**
     * Set meta keywords
     *
     * @param string $metaKeywords Meta keywords
     *
     * @return Object self Object
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * Get meta keywords
     *
     * @return string Meta keywords
     */
    public function getMetaKeywords();

    /**
     * Set meta title
     *
     * @param string $metaTitle Meta title
     *
     * @return Object self Object
     */
    public function setMetaTitle($metaTitle);

    /**
     * Get meta title
     *
     * @return string Meta title
     */
    public function getMetaTitle();
}
