<?php

/**
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

namespace Elcodi\CartBundle\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;

/**
 * Class CartSessionManager
 *
 * Manages all cart mapping in session
 *
 * Api Methods:
 *
 * * set(Cart) : self
 * * get() : integer
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
     * @var boolean
     *
     * Save cart in session
     */
    protected $saveInSession;

    /**
     * Construct method
     *
     * @param SessionInterface $session          HTTP session
     * @param string           $sessionFieldName Session key representing cart
     * @param boolean          $saveInSession    save cart in session
     */
    public function __construct(
        SessionInterface $session,
        $sessionFieldName,
        $saveInSession
    )
    {
        $this->session = $session;
        $this->sessionFieldName = $sessionFieldName;
        $this->saveInSession = $saveInSession;
    }

    /**
     * Set Cart in session
     *
     * @param CartInterface $cart Cart
     *
     * @return CartSessionManager self Object
     */
    public function set(CartInterface $cart)
    {
        if (!$this->saveInSession) {
            return $this;
        }

        $this
            ->session
            ->set(
                $this->sessionFieldName,
                $cart->getId()
            );

        return $this;
    }

    /**
     * Get current cart id loaded in session
     *
     * @return integer Cart id
     */
    public function get()
    {
        return $this
            ->session
            ->get($this->sessionFieldName);
    }
}
