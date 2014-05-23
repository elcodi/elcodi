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

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Elcodi\CartBundle\Event\CartPostLoadEvent;

class SessionEventListener
{
    /**
     * @var SessionInterface
     *
     * Session
     */
    protected $session;

    /**
     * @var string
     *
     * Session Field Name
     */
    protected $sessionFieldName;

    /**
     * Construct method
     *
     * @param SessionInterface $session          HTTP session
     * @param string           $sessionFieldName Session key representing customer id
     */
    public function __construct(SessionInterface $session, $sessionFieldName)
    {
        $this->session = $session;
        $this->sessionFieldName = $sessionFieldName;
    }

    /**
     * Stores cart id in HTTP session.
     *
     * @param CartPostLoadEvent $event
     */
    public function onCartPostLoad(CartPostLoadEvent $event)
    {
        $cart = $event->getCart();

        if ($this->session->get($this->sessionFieldName) != $cart->getId()) {

            $this->session->set($this->sessionFieldName, $cart->getId());
        }
    }
}
