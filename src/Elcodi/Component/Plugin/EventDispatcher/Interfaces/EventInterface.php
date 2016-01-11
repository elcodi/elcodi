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

namespace Elcodi\Component\Plugin\EventDispatcher\Interfaces;

/**
 * Interface Event.
 *
 * @author Berny Cantos <be@rny.cc>
 */
interface EventInterface
{
    /**
     * Get a value from the context, with a fallback default.
     *
     * @param string     $key     Index in the context
     * @param mixed|null $default Default value if there's no entry
     *
     * @return array
     */
    public function get($key, $default = null);

    /**
     * Get full context.
     *
     * @return array
     */
    public function getContext();

    /**
     * Get current content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set current content.
     *
     * @param string $content
     *
     * @return $this Self object
     */
    public function setContent($content);
}
