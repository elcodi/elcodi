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
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;
use Elcodi\Component\Cart\Event\OrderPreCreatedEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class OrderEventDispatcher.
 */
class OrderEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Event dispatched just before a Cart is converted to an Order.
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function dispatchOrderPreCreatedEvent(
        CartInterface $cart
    ) {
        $orderPreCreatedEvent = new OrderPreCreatedEvent($cart);
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDER_PRECREATED,
            $orderPreCreatedEvent
        );
    }

    /**
     * Event dispatched when a Cart is being converted to an Order.
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function dispatchOrderOnCreatedEvent(
        CartInterface $cart,
        OrderInterface $order
    ) {
        $orderPreCreatedEvent = new OrderOnCreatedEvent($cart, $order);
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDER_ONCREATED,
            $orderPreCreatedEvent
        );

        return $this;
    }
}
