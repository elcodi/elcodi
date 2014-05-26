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

namespace Elcodi\CartBundle\EventListener;

use Elcodi\CartBundle\Services\CartSessionManager;

use Elcodi\CartBundle\Event\CartPostLoadEvent;

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
     * Stores cart id in HTTP session.
     *
     * @param CartPostLoadEvent $event
     */
    public function onCartPostLoad(CartPostLoadEvent $event)
    {
        $this->cartSessionManager->set($event->getCart());
    }
}
