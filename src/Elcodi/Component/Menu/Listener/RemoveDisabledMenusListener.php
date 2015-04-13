<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Menu\Listener;

use Elcodi\Component\Menu\Event\MenuEvent;

/**
 * Class RemoveDisabledMenusListener
 *
 * @author Berny Cantos <be@rny.cc>
 */
class RemoveDisabledMenusListener
{
    /**
     * Mark menu entries as active if matches the current route.
     * Also mark entries as expanded if any subnode is the current route.
     *
     * @param MenuEvent $event
     */
    public function onMenuPostCompilation(MenuEvent $event)
    {
        $event->addFilter(function (array $item) {

            if ($item['enabled'] === false) {
                return false;
            }

            return $item;
        });
    }
}
