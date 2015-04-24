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

namespace Elcodi\Component\Menu\EventDispatcher\Interfaces;

use Elcodi\Component\Menu\Event\PostMenuCompilationEvent;
use Elcodi\Component\Menu\Event\PostMenuLoadEvent;

/**
 * Interface MenuEventDispatcherInterface
 */
interface MenuEventDispatcherInterface
{
    /**
     * Dispatch Post Compilation event
     *
     * @param string $menuCode Menu code
     * @param array  $nodes    Menu nodes
     *
     * @return PostMenuCompilationEvent Created event
     */
    public function dispatchPostMenuCompilation(
        $menuCode,
        array $nodes
    );

    /**
     * Dispatch Post Load event
     *
     * @param string $menuCode Menu code
     * @param array  $nodes    Menu nodes
     *
     * @return PostMenuLoadEvent Created event
     */
    public function dispatchPostMenuLoad(
        $menuCode,
        array $nodes
    );
}
