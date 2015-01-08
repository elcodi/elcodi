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

namespace Elcodi\Component\Sitemap\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class SitemapGeneratedEvent
 */
class SitemapGeneratedEvent extends Event
{
    /**
     * @var string
     *
     * Path
     */
    protected $path;

    /**
     * @var string
     *
     * Data
     */
    protected $data;

    /**
     * Construct
     *
     * @param string $data Data
     * @param string $path Path
     */
    public function __construct($data, $path)
    {
        $this->data = $data;
        $this->path = $path;
    }

    /**
     * Get Data
     *
     * @return mixed Data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get Path
     *
     * @return string Path
     */
    public function getPath()
    {
        return $this->path;
    }
}
