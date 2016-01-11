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
use Elcodi\Component\Cart\Event\CartInconsistentEvent;
use Elcodi\Component\Cart\Event\CartOnEmptyEvent;
use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Cart\Event\CartPreLoadEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class CartEventDispatcher.
 */
class CartEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch all cart events.
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function dispatchCartLoadEvents(CartInterface $cart)
    {
        $this
            ->dispatchCartPreLoadEvent($cart)
            ->dispatchCartOnLoadEvent($cart);

        $cart->setLoaded(true);

        return $this;
    }

    /**
     * Dispatch cart event just before is loaded.
     *
     * This event is dispatched while final elements on Cart environment
     * have not been calculated and completed.
     *
     * This event should have all needed entity change, for example,
     * remove a cartLine if cannot be used in cart ( Product out of stock )
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function dispatchCartPreLoadEvent(CartInterface $cart)
    {
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_PRELOAD,
            new CartPreLoadEvent($cart)
        );

        return $this;
    }

    /**
     * Dispatch event when Cart is loaded.
     *
     * This event considers that all changes related with the entity have
     * been executed. At this point, all related operations can be done, for
     * example, final price calculation
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function dispatchCartOnLoadEvent(CartInterface $cart)
    {
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_ONLOAD,
            new CartOnLoadEvent($cart)
        );

        return $this;
    }

    /**
     * Dispatch cart event for inconsistent cart.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return $this Self object
     */
    public function dispatchCartInconsistentEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_INCONSISTENT,
            new CartInconsistentEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }

    /**
     * Dispatch cart event when a cart ois emptied.
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function dispatchCartOnEmptyEvent(CartInterface $cart)
    {
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_ONEMPTY,
            new CartOnEmptyEvent($cart)
        );

        return $this;
    }
}
