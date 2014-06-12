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

namespace Elcodi\CartBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;

/**
 * Class AbstractOrderStateEvent
 */
class AbstractOrderStateEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var OrderHistoryInterface
     *
     * Last OrderHistory object
     */
    protected $lastOrderHistory;

    /**
     * @var string
     *
     * New state
     */
    protected $newState;

    /**
     * construct method
     *
     * @param OrderInterface        $order            Order
     * @param OrderHistoryInterface $lastOrderHistory Last OrderHistory
     * @param string                $newState         New state to reach
     */
    public function __construct(
        OrderInterface $order,
        OrderHistoryInterface $lastOrderHistory,
        $newState
    )
    {
        $this->order = $order;
        $this->lastOrderHistory = $lastOrderHistory;
        $this->newState = $newState;
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
     * Return last OrderLineHistory object
     *
     * @return OrderHistoryInterface last OrderLineHistory object
     */
    public function getLastOrderHistory()
    {
        return $this->lastOrderHistory;
    }

    /**
     * Return new state to reach
     *
     * @return string New state to reach
     */
    public function getNewState()
    {
        return $this->newState;
    }
}
