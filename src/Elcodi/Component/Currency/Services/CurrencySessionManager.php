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

namespace Elcodi\Component\Currency\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Class CurrencySessionManager
 */
class CurrencySessionManager
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
     * @param string           $sessionFieldName Session key representing currency id
     */
    public function __construct(SessionInterface $session, $sessionFieldName)
    {
        $this->session = $session;
        $this->sessionFieldName = $sessionFieldName;
    }

    /**
     * Set Currency in session
     *
     * @param CurrencyInterface $currency Currency
     *
     * @return $this self Object
     */
    public function set(CurrencyInterface $currency)
    {
        $this->session->set($this->sessionFieldName, $currency->getId());

        return $this;
    }

    /**
     * Get current cart id loaded in session
     *
     * @return integer Currency id
     */
    public function get()
    {
        return $this->session->get($this->sessionFieldName);
    }
}
