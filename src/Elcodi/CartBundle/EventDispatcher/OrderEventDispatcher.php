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
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Event\OrderPreCreatedEvent;
use Elcodi\CartBundle\Event\OrderOnCreatedEvent;
use Elcodi\CartBundle\ElcodiCartEvents;

/**
 * Class OrderEventDispatcher
 */
class OrderEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Event dispatched just before a Cart is converted to an Order
     *
     * @param CartInterface $cart Cart
     *
     * @return OrderEventDispatcher self Object
     */
    public function dispatchOrderPreCreatedEvent(
        CartInterface $cart
    )
    {
        $orderPreCreatedEvent = new OrderPreCreatedEvent($cart);
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDER_PRECREATED,
            $orderPreCreatedEvent
        );
    }

    /**
     * Event dispatched when a Cart is being converted to an Order
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order Order
     *
     * @return OrderEventDispatcher self Object
     */
    public function dispatchOrderOnCreatedEvent(
        CartInterface $cart,
        OrderInterface $order
    )
    {
        $orderPreCreatedEvent = new OrderOnCreatedEvent($cart, $order);
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDER_ONCREATED,
            $orderPreCreatedEvent
        );

        return $this;
    }
}
