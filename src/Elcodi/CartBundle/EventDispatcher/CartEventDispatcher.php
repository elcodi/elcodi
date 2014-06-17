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

use Elcodi\CoreBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Event\CartInconsistentEvent;
use Elcodi\CartBundle\Event\CartOnEmptyEvent;
use Elcodi\CartBundle\Event\CartPreLoadEvent;
use Elcodi\CartBundle\Event\CartOnLoadEvent;
use Elcodi\CartBundle\ElcodiCartEvents;

/**
 * Class CartEventDispatcher
 */
class CartEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch all cart events
     *
     * @param CartInterface $cart Cart
     *
     * @return CartEventDispatcher self object
     *
     * @api
     */
    public function dispatchCartLoadEvents(CartInterface $cart)
    {
        return $this
            ->dispatchCartPreLoadEvent($cart)
            ->dispatchCartOnLoadEvent($cart);
    }

    /**
     * Dispatch cart event just before is loaded
     *
     * This event is dispatched while final elements on Cart environment
     * have not been calculated and completed.
     *
     * This event should have all needed entity change, for example,
     * remove a cartLine if cannot be used in cart ( Product out of stock )
     *
     * @param CartInterface $cart Cart
     *
     * @return CartEventDispatcher self object
     *
     * @api
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
     * Dispatch event when Cart is loaded
     *
     * This event considers that all changes related with the entity have
     * been executed. At this point, all related operations can be done, for
     * example, final price calculation
     *
     * @param CartInterface $cart Cart
     *
     * @return CartEventDispatcher self object
     *
     * @api
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
     * Dispatch cart event for inconsistent cart
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return CartEventDispatcher self object
     *
     * @api
     */
    public function dispatchCartInconsistentEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
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
     * Dispatch cart event when a cart ois emptied
     *
     * @param CartInterface $cart Cart
     *
     * @return CartEventDispatcher self object
     *
     * @api
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
