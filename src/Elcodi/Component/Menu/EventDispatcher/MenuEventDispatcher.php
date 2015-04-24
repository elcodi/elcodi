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

namespace Elcodi\Component\Menu\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Menu\ElcodiMenuEvents;
use Elcodi\Component\Menu\Event\PostMenuCompilationEvent;
use Elcodi\Component\Menu\Event\PostMenuLoadEvent;
use Elcodi\Component\Menu\EventDispatcher\Interfaces\MenuEventDispatcherInterface;

/**
 * Class MenuEventDispatcher
 */
class MenuEventDispatcher extends AbstractEventDispatcher implements MenuEventDispatcherInterface
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
    ) {
        $event = new PostMenuCompilationEvent(
            $menuCode,
            $nodes
        );

        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiMenuEvents::POST_COMPILATION,
                $event
            );

        return $event;
    }

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
    ) {
        $event = new PostMenuLoadEvent(
            $menuCode,
            $nodes
        );

        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiMenuEvents::POST_LOAD,
                $event
            );

        return $event;
    }
}
