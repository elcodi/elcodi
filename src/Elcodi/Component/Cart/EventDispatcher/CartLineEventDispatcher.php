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

namespace Elcodi\Component\Cart\EventDispatcher;

use Elcodi\Component\Cart\ElcodiCartEvents;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Event\CartLineOnAddEvent;
use Elcodi\Component\Cart\Event\CartLineOnEditEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class CartLineEventDispatcher.
 */
class CartLineEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch cartLine event when is added into cart.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return $this Self object
     */
    public function dispatchCartLineOnAddEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
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
     * Dispatch cartLine event when is edited.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return $this Self object
     */
    public function dispatchCartLineOnEditEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
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
     * Dispatch cartLine event when is removed.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return $this Self object
     */
    public function dispatchCartLineOnRemoveEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CARTLINE_ONREMOVE,
            new CartLineOnAddEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }
}
