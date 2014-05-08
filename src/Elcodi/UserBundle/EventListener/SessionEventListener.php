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

namespace Elcodi\UserBundle\EventListener;

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
     * Stores customer id in HTTP session.
     *
     * When a Cart is loaded and flushed, if the
     * associated Customer is not stored yet, it gets
     * flushed too. When this event occurs, the newly
     * generated Customer entity should be associated
     * with current HTTP session.
     * This is achieved by storing Customer::id in
     * session
     *
     * @param CartPostLoadEvent $event
     */
    public function onCartPostLoad(CartPostLoadEvent $event)
    {
        $cart = $event->getCart();

        if ($this->session->get($this->sessionFieldName) != $cart->getCustomer()->getId()) {

            $this->session->set($this->sessionFieldName, $cart->getCustomer()->getId());
        }
    }
}
