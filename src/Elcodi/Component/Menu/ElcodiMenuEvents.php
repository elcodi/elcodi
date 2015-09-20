<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Menu;

/**
 * Class ElcodiMenuEvents
 *
 * @author Berny Cantos <be@rny.cc>
 */
final class ElcodiMenuEvents
{
    /**
     * This event is fired after compiling a menu.
     * When the menu is get from cache, this event is not fired.
     *
     * event.name : menu.post_compilation
     * event.class : MenuEvent
     */
    const POST_COMPILATION = 'menu.post_compilation';

    /**
     * This event is fired after loading a menu, even if it comes from cache.
     *
     * event.name : menu.post_load
     * event.class : MenuEvent
     */
    const POST_LOAD = 'menu.post_load';
}
