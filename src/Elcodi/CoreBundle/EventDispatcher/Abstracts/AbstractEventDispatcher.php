<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\EventDispatcher\Abstracts;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AbstractEventDispatcher
 */
abstract class AbstractEventDispatcher
{
    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Contstruct method
     *
     * @param EventDispatcherInterface $eventDispatcher Event Dispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
}
