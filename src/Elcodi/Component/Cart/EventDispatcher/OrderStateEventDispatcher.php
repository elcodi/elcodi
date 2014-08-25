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

namespace Elcodi\Component\Cart\EventDispatcher;

use Elcodi\Component\Cart\ElcodiCartEvents;
use Elcodi\Component\Cart\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Event\OrderStateOnChangeEvent;
use Elcodi\Component\Cart\Event\OrderStatePreChangeEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class OrderStateEventDispatcher
 */
class OrderStateEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatching "pre" state changed event
     *
     * This event does not pass wrap new OrderLineHistory into the message,
     * since it has not been created yet.
     *
     * @param OrderInterface        $order            Used Order
     * @param OrderHistoryInterface $lastOrderHistory Last OrderHistory
     * @param string                $newState         New state to reach
     *
     * @return OrderLineStateEventDispatcher self Object
     */
    public function dispatchOrderStatePreChangeEvent(
        OrderInterface $order,
        OrderHistoryInterface $lastOrderHistory,
        $newState
    )
    {
        $orderStatePreChangeEvent = new OrderStatePreChangeEvent(
            $order,
            $lastOrderHistory,
            $newState
        );

        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiCartEvents::ORDER_STATE_PRECHANGE,
                $orderStatePreChangeEvent
            );

        return $this;
    }

    /**
     * Dispatching "post" state changed event
     *
     * New OrderLineHistory has been created already
     *
     * @param OrderInterface        $order            Used Order
     * @param OrderHistoryInterface $lastOrderHistory Last OrderHistory
     * @param OrderHistoryInterface $newOrderHistory  New OrderHistory
     * @param string                $newState         New state to reach
     *
     * @return OrderLineStateEventDispatcher self Object
     */
    public function dispatchOrderStatePostChangeEvent(
        OrderInterface $order,
        OrderHistoryInterface $lastOrderHistory,
        OrderHistoryInterface $newOrderHistory,
        $newState
    )
    {
        $orderStatePostChangeEvent = new OrderStateOnChangeEvent(
            $order,
            $lastOrderHistory,
            $newOrderHistory,
            $newState
        );

        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiCartEvents::ORDER_STATE_POSTCHANGE,
                $orderStatePostChangeEvent
            );

        return $this;
    }
}
