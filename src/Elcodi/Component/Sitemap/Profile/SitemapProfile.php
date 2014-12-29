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

namespace Elcodi\Component\Sitemap\Profile;

use Elcodi\Component\Sitemap\Loader\Interfaces\EntityLoaderInterface;
use Elcodi\Component\Sitemap\Profile\Interfaces\SitemapProfileInterface;

/**
 * Class SitemapProfile
 */
class SitemapProfile implements SitemapProfileInterface
{
    /**
     * @var EntityLoaderInterface[]
     *
     * Entity loaders
     */
    protected $entityLoaders;

    /**
     * @var string
     *
     * Path
     */
    protected $path;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * Construct
     *
     * @param string $name Name
     * @param string $path Path
     */
    public function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = $path;
    }

    /**
     * Add entity loader
     *
     * @param EntityLoaderInterface $entityLoader Entity Loader
     *
     * @return $this self Object
     */
    public function addEntityLoader(EntityLoaderInterface $entityLoader)
    {
        $this->entityLoaders[] = $entityLoader;

        return $this;
    }

    /**
     * Get Entity loaders
     *
     * @return EntityLoaderInterface[] Entity loaders
     */
    public function getEntityLoaders()
    {
        return $this->entityLoaders;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
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
