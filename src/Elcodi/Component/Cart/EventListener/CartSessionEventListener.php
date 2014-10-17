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

namespace Elcodi\Component\Cart\EventListener;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Cart\Services\CartSessionManager;

/**
 * Class CartSessionEventListener
 */
class CartSessionEventListener
{
    /**
     * @var CartSessionManager
     *
     * CartSessionManager
     */
    protected $cartSessionManager;

    /**
     * Construct method
     *
     * @param CartSessionManager $cartSessionManager CartSessionManager
     */
    public function __construct(CartSessionManager $cartSessionManager)
    {
        $this->cartSessionManager = $cartSessionManager;
    }

    /**
     * Stores cart id in HTTP session when this is saved
     *
     * @param CartOnLoadEvent $event Event
     */
    public function onCartLoad(CartOnLoadEvent $event)
    {
        $this
            ->cartSessionManager
            ->set($event->getCart());
    }
}
