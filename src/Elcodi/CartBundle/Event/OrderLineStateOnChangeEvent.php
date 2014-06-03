<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Event;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Event\Abstracts\AbstractOrderLineStateEvent;

/**
 * Event dispatched when a new state is added into OrderLineHistory
 *
 * This event saves Order line and new state
 */
class OrderLineStateOnChangeEvent extends AbstractOrderLineStateEvent
{
    /**
     * @var OrderLineHistoryInterface
     *
     * New OrderLineHistory
     */
    protected $newOrderLineHistory;

    /**
     * construct method
     *
     * @param OrderInterface            $order                Used Order
     * @param OrderLineInterface        $orderLine            Used OrderLine
     * @param OrderLineHistoryInterface $lastOrderLineHistory Last OrderLineHistory
     * @param OrderLineHistoryInterface $newOrderLineHistory  New OrderLineHistory
     * @param string                    $newState             New state to reach
     */
    public function __construct(
        OrderInterface $order,
        OrderLineInterface $orderLine,
        OrderLineHistoryInterface $lastOrderLineHistory,
        OrderLineHistoryInterface $newOrderLineHistory,
        $newState
    )
    {
        parent::__construct(
            $order,
            $orderLine,
            $lastOrderLineHistory,
            $newState
        );

        $this->newOrderLineHistory = $newOrderLineHistory;
    }

    /**
     * Return OrderLineHistory object
     *
     * @return OrderLineHistoryInterface OrderLineHistory object
     */
    public function getNewOrderLineHistory()
    {
        return $this->newOrderLineHistory;
    }
}
