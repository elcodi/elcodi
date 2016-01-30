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
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Event\OrderLineOnCreatedEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class OrderLineEventDispatcher.
 */
class OrderLineEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Event dispatched when a Cart is being converted to an OrderLine.
     *
     * @param OrderInterface     $order     Order
     * @param CartLineInterface  $cartLine  CartLine
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return $this Self object
     */
    public function dispatchOrderLineOnCreatedEvent(
        OrderInterface $order,
        CartLineInterface $cartLine,
        OrderLineInterface $orderLine
    ) {
        $orderLineOnCreatedEvent = new OrderLineOnCreatedEvent(
            $order,
            $cartLine,
            $orderLine
        );

        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDERLINE_ONCREATED,
            $orderLineOnCreatedEvent
        );

        return $this;
    }
}
