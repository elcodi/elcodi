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
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Event\OrderLineOnCreatedEvent;
use Elcodi\CoreBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class OrderLineEventDispatcher
 */
class OrderLineEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Event dispatched when a Cart is being converted to an OrderLine
     *
     * @param OrderInterface     $order     Order
     * @param CartLineInterface  $cartLine  CartLine
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return OrderLineEventDispatcher self Object
     */
    public function dispatchOrderLineOnCreatedEvent(
        OrderInterface $order,
        CartLineInterface $cartLine,
        OrderLineInterface $orderLine
    )
    {
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
