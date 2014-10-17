<?php

/*
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

namespace Elcodi\Component\Cart\EventDispatcher;

use Elcodi\Component\Cart\ElcodiCartEvents;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Event\OrderLineStateOnChangeEvent;
use Elcodi\Component\Cart\Event\OrderLineStatePreChangeEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class OrderLineEventDispatcher
 */
class OrderLineStateEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Event dispatcher before OrderLineState changes
     *
     * This event does not pass wrap new OrderLineHistory into the message,
     * since it has not been created yet.
     *
     * @param OrderInterface            $order                Used Order
     * @param OrderLineInterface        $orderLine            Used OrderLine
     * @param OrderLineHistoryInterface $lastOrderLineHistory Last OrderLineHistory
     * @param string                    $newState             New state to reach
     *
     * @return $this self Object
     */
    public function dispatchOrderLineStatePreChangeEvent(
        OrderInterface $order,
        OrderLineInterface $orderLine,
        OrderLineHistoryInterface $lastOrderLineHistory,
        $newState
    )
    {
        $orderLineStatePreChangeEvent = new OrderLineStatePreChangeEvent(
            $order,
            $orderLine,
            $lastOrderLineHistory,
            $newState
        );
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDERLINE_STATE_PRECHANGE,
            $orderLineStatePreChangeEvent
        );

        return $this;
    }

    /**
     * Event dispatcher when OrderLineState changes
     *
     * New OrderLineHistory has been created already
     *
     * @param OrderInterface            $order                Used Order
     * @param OrderLineInterface        $orderLine            Used OrderLine
     * @param OrderLineHistoryInterface $lastOrderLineHistory Last OrderLineHistory
     * @param OrderLineHistoryInterface $newOrderLineHistory  New OrderLineHistory
     * @param string                    $newState             New state to reach
     *
     * @return $this self Object
     */
    public function dispatchOrderLineStateOnChangeEvent(
        OrderInterface $order,
        OrderLineInterface $orderLine,
        OrderLineHistoryInterface $lastOrderLineHistory,
        OrderLineHistoryInterface $newOrderLineHistory,
        $newState
    )
    {
        $orderLineStatePostChangeEvent = new OrderLineStateOnChangeEvent(
            $order,
            $orderLine,
            $lastOrderLineHistory,
            $newOrderLineHistory,
            $newState
        );

        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDERLINE_STATE_POSTCHANGE,
            $orderLineStatePostChangeEvent
        );

        return $this;
    }
}
