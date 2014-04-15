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

namespace Elcodi\CartBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;

/**
 * Class AbstractOrderLineStateEvent
 */
class AbstractOrderLineStateEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var OrderLineInterface
     *
     * Order line
     */
    protected $orderLine;

    /**
     * @var OrderLineHistoryInterface
     *
     * Last OrderLineHistory object
     */
    protected $lastOrderLineHistory;

    /**
     * construct method
     *
     * @param OrderInterface            $order                Order
     * @param OrderLineInterface        $orderLine            Order line
     * @param OrderLineHistoryInterface $lastOrderLineHistory Last OrderLine history
     */
    public function __construct(
        OrderInterface $order,
        OrderLineInterface $orderLine,
        OrderLineHistoryInterface $lastOrderLineHistory
    )
    {
        $this->order = $order;
        $this->orderLine = $orderLine;
        $this->lastOrderLineHistory = $lastOrderLineHistory;
    }

    /**
     * Return order
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Return event order line
     *
     * @return OrderLineInterface Order line
     */
    public function getOrderLine()
    {
        return $this->orderLine;
    }

    /**
     * Return last OrderLineHistory object
     *
     * @return OrderLineHistoryInterface last OrderLineHistory object
     */
    public function getLastOrderLineHistory()
    {
        return $this->lastOrderLineHistory;
    }
}
