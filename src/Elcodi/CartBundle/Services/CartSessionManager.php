<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;

/**
 * Class CartSessionManager
 */
class CartSessionManager
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
     * Set Cart in session
     *
     * @param CartInterface $cart Cart
     *
     * @return CartSessionManager self Object
     *
     * @api
     */
    public function set(CartInterface $cart)
    {
        $this->session->set($this->sessionFieldName, $cart->getId());

        return $this;
    }

    /**
     * Get current cart id loaded in session
     *
     * @return integer Cart id
     *
     * @api
     */
    public function get()
    {
        return $this->session->get($this->sessionFieldName);
    }
}
