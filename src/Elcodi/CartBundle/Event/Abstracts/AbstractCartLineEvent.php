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
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;

/**
 * Class AbstractCartLineEvent
 */
abstract class AbstractCartLineEvent extends Event
{
    /**
     * @var CartInterface
     *
     * cart
     */
    protected $cart;

    /**
     * @var CartLineInterface
     *
     * cartLine
     */
    protected $cartLine;

    /**
     * Construct method
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     */
    public function __construct(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
        $this->cart = $cart;
        $this->cartLine = $cartLine;
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

    /**
     * Get cartLine
     *
     * @return CartLineInterface Cart Line
     */
    public function getCartLine()
    {
        return $this->cartLine;
    }
}
