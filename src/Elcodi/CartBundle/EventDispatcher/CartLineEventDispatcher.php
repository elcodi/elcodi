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

namespace Elcodi\CartBundle\EventDispatcher;

use Elcodi\CartBundle\ElcodiCartEvents;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Event\CartLineOnAddEvent;
use Elcodi\CartBundle\Event\CartLineOnEditEvent;
use Elcodi\CoreBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class CartLineEventDispatcher
 */
class CartLineEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch cartLine event when is added into cart
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return CartEventDispatcher self object
     *
     * @api
     */
    public function dispatchCartLineOnAddEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CARTLINE_ONADD,
            new CartLineOnAddEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }

    /**
     * Dispatch cartLine event when is edited
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return CartEventDispatcher self object
     *
     * @api
     */
    public function dispatchCartLineOnEditEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CARTLINE_ONEDIT,
            new CartLineOnEditEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }

    /**
     * Dispatch cartLine event when is added into cart
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return CartEventDispatcher self object
     *
     * @api
     */
    public function dispatchCartLineOnRemoveEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CARTLINE_ONADD,
            new CartLineOnAddEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }
}
