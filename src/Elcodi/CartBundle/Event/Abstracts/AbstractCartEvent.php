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

namespace Elcodi\CartBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;

/**
 * Class AbstractCartEvent
 */
abstract class AbstractCartEvent extends Event
{
    /**
     * @var CartInterface
     *
     * cart
     */
    protected $cart;

    /**
     * Construct method
     *
     * @param CartInterface $cart Cart
     */
    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get cart
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }
}
