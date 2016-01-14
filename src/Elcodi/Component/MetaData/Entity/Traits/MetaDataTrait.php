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

namespace Elcodi\Component\MetaData\Entity\Traits;

/**
 * Trait for add Meta data.
 */
trait MetaDataTrait
{
    /**
     * @var string
     *
     * Meta title
     */
    protected $metaTitle;

    /**
     * @var string
     *
     * Meta description
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * Meta keywords
     */
    protected $metaKeywords;

    /**
     * Set meta description.
     *
     * @param string $metaDescription
     *
     * @return $this Self object
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get meta description.
     *
     * @return string Meta description
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set meta keywords.
     *
     * @param string $metaKeywords Meta keywords
     *
     * @return $this Self object
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get meta keywords.
     *
     * @return string Meta keywords
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set meta title.
     *
     * @param string $metaTitle Meta title
     *
     * @return $this Self object
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get meta title.
     *
     * @return string Meta title
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }
}
