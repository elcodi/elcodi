<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Cart\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;

/**
 * Class AbstractCartLineEvent.
 */
abstract class AbstractCartLineEvent extends Event
{
    /**
     * @var CartInterface
     *
     * cart
     */
    private $cart;

    /**
     * @var CartLineInterface
     *
     * cartLine
     */
    private $cartLine;

    /**
     * Construct method.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     */
    public function __construct(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->cart = $cart;
        $this->cartLine = $cartLine;
    }

    /**
     * Get cart.
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Get cartLine.
     *
     * @return CartLineInterface Cart Line
     */
    public function getCartLine()
    {
        return $this->cartLine;
    }
}
