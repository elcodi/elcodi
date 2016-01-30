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

namespace Elcodi\Component\Sitemap\Element;

/**
 * Class SitemapElement.
 */
class SitemapElement
{
    /**
     * @var string
     *
     * location
     */
    private $location;

    /**
     * @var null|string
     *
     * lastModification
     */
    private $lastModification;

    /**
     * @var null|string
     *
     * changeFrequency
     */
    private $changeFrequency;

    /**
     * @var null|string
     *
     * priority
     */
    private $priority;

    /**
     * Constructor.
     *
     * @param string      $location         Location
     * @param string|null $lastModification Last modification
     * @param string|null $changeFrequency  Change frequency
     * @param string|null $priority         Priority
     */
    public function __construct(
        $location,
        $lastModification = null,
        $changeFrequency = null,
        $priority = null
    ) {
        $this->location = $location;
        $this->lastModification = $lastModification;
        $this->changeFrequency = $changeFrequency;
        $this->priority = $priority;
    }

    /**
     * Get Location.
     *
     * @return string Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get LastModification.
     *
     * @return string|null LastModification
     */
    public function getLastModification()
    {
        return $this->lastModification;
    }

    /**
     * Get ChangeFrequency.
     *
     * @return string|null ChangeFrequency
     */
    public function getChangeFrequency()
    {
        return $this->changeFrequency;
    }

    /**
     * Get Priority.
     *
     * @return string|null Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
