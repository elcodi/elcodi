<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Event;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Event\Abstracts\AbstractOrderLineStateEvent;

/**
 * Event fired when a new state is added into OrderLineHistory
 *
 * This event saves Order line and new state
 */
class OrderLineStatePostChangeEvent extends AbstractOrderLineStateEvent
{
    /**
     * @var OrderLineHistoryInterface
     *
     * OrderLineHistory object
     */
    protected $orderLineHistory;

    /**
     * construct method
     *
     * @param OrderInterface            $order                Order
     * @param OrderLineInterface        $orderLine            Order line
     * @param OrderLineHistoryInterface $lastOrderLineHistory Last OrderLine history
     * @param OrderLineHistoryInterface $orderLineHistory     OrderLine History
     */
    public function __construct(
        OrderInterface $order,
        OrderLineInterface $orderLine,
        OrderLineHistoryInterface $lastOrderLineHistory,
        OrderLineHistoryInterface $orderLineHistory
    )
    {
        parent::__construct($order, $orderLine, $lastOrderLineHistory);

        $this->orderLineHistory = $orderLineHistory;
    }

    /**
     * Return OrderLineHistory object
     *
     * @return OrderLineHistoryInterface OrderLineHistory object
     */
    public function getOrderLineHistory()
    {
        return $this->orderLineHistory;
    }
}
