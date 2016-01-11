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
 * Interface HookSystemEventDispatcherInterface.
 *
 * @author Berny Cantos <be@rny.cc>
 */
interface HookSystemEventDispatcherInterface
{
    /**
     * Start listening on a specified hook.
     *
     * @param string   $hookName Name of the hook to listen
     * @param callable $callable Function to call on hook execution
     *
     * @return $this Self object
     */
    public function listen($hookName, $callable);

    /**
     * Dispatches all listeners and filters related to a hook.
     *
     * @param string $hookName Name of the hook to run
     * @param array  $context  Context in which the hook should run
     * @param string $content  Optional original content
     *
     * @return mixed Content after transformation
     */
    public function execute($hookName, array $context = [], $content = '');
}
