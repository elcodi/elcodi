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

namespace Elcodi\Component\Plugin\Adapter\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Plugin\HookSystemInterface;

/**
 * Class HookSystemAdapter
 *
 * Implements HookSystem over Symfony EventDispatcher component
 *
 * @author Berny Cantos <be@rny.cc>
 */
class HookSystemAdapter implements HookSystemInterface
{
    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher which will dispatch the events
     */
    protected $eventDispatcher;

    /**
     * Construct
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Start listening on a specified hook.
     *
     * @param string   $hookName Name of the hook to listen
     * @param callable $callable Function to call on hook execution
     *
     * @return $this self Object
     */
    public function listen($hookName, $callable)
    {
        $this->eventDispatcher->addListener($hookName, $callable);

        return $this;
    }

    /**
     * Dispatches all listeners and filters related to a hook.
     *
     * @param string $hookName Name of the hook to run
     * @param array  $context  Context in which the hook should run
     * @param string $content  Optional original content
     *
     * @return mixed Content after transformation
     */
    public function execute($hookName, $context = array(), $content = '')
    {
        $event = new EventAdapter($context, $content);
        $this->eventDispatcher->dispatch($hookName, $event);

        return $event->getContent();
    }
}
