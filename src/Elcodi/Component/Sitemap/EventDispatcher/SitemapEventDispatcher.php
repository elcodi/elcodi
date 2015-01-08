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

namespace Elcodi\Component\Sitemap\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Sitemap\ElcodiSitemapEvents;
use Elcodi\Component\Sitemap\Event\SitemapGeneratedEvent;

/**
 * Class SitemapEventDispatcher
 */
class SitemapEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch sitemap generated event
     *
     * @param string $data Data
     * @param string $path Path
     *
     * @return $this self Object
     */
    public function dispatchSitemapGeneratedEvent($path, $data)
    {
        $sitemapGeneratedEvent = new SitemapGeneratedEvent($path, $data);

        $this->eventDispatcher->dispatch(
            ElcodiSitemapEvents::SITEMAP_GENERATED,
            $sitemapGeneratedEvent
        );

        return $this;
    }
}
