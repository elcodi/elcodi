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

namespace Elcodi\CartBundle\Services;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\EventDispatcher\OrderLineStateEventDispatcher;
use Elcodi\CartBundle\Factory\OrderLineFactory;
use Elcodi\CartBundle\Factory\OrderLineHistoryFactory;

/**
 * Order Line History manager
 *
 * Manages all histories in specific OrderLine
 *
 * Api Methods:
 *
 * * addStateToOrderLine(OrderInterface,OrderLineInterface, $newState) : self
 * * checkOrderLineCanChangeToState(OrderLineInterface, $newState) : boolean
 */
class OrderLineManager
{
    /**
     * @var OrderLineStateEventDispatcher
     *
     * OrderLineStateEventDispatcher
     */
    protected $orderLineStateEventDispatcher;

    /**
     * @var OrderLineHistoryFactory
     *
     * orderLineHistoryFactory
     */
    protected $orderLineHistoryFactory;

    /**
     * @var OrderLineFactory
     *
     * OrderLine factory
     */
    protected $orderLineFactory;

    /**
     * @var OrderStateManager
     *
     * OrderStateManager
     */
    protected $orderStateManager;

    /**
     * Construct method
     *
     * @param OrderLineStateEventDispatcher $orderLineStateEventDispatcher OrderLineEventDispatcher
     * @param OrderLineHistoryFactory       $orderLineHistoryFactory       Order line history factory
     * @param OrderLineFactory              $orderLineFactory              OrderLineFactory
     * @param OrderStateManager             $orderStateManager             OrderStateManager
     */
    public function __construct(
        OrderLineStateEventDispatcher $orderLineStateEventDispatcher,
        OrderLineHistoryFactory $orderLineHistoryFactory,
        OrderLineFactory $orderLineFactory,
        OrderStateManager $orderStateManager
    )
    {
        $this->orderLineStateEventDispatcher = $orderLineStateEventDispatcher;
        $this->orderLineHistoryFactory = $orderLineHistoryFactory;
        $this->orderLineFactory = $orderLineFactory;
        $this->orderStateManager = $orderStateManager;

    }

    /**
     * Given an existing OrderLine, changes its state and creates a new HistoryState.
     * 'PreChange' and 'PostChange' events are fired, which by default are observed by
     * OrderManager and OrderLineManager to enforce the validity of the state transitions.
     *
     * @param OrderInterface     $order     Order
     * @param OrderLineInterface $orderLine Orderline object
     * @param String             $newState  New state to append
     *
     * @return OrderLineManager self Object
     */
    public function addStateToOrderLine(
        OrderInterface $order,
        OrderLineInterface $orderLine,
        $newState
    )
    {
        $lastOrderLineHistory = $orderLine->getOrderLineHistories()->last();

        $this
            ->orderLineStateEventDispatcher
            ->dispatchOrderLineStatePreChangeEvent(
                $order,
                $orderLine,
                $lastOrderLineHistory,
                $newState
            );

        /**
         * @var OrderLineHistoryInterface $orderLineHistory
         */
        $orderLineHistory = $this->orderLineHistoryFactory->create();
        $orderLineHistory
            ->setState($newState)
            ->setOrderLine($orderLine);

        $orderLine
            ->addOrderLineHistory($orderLineHistory)
            ->setLastOrderLineHistory($orderLineHistory);

        $this
            ->orderLineStateEventDispatcher
            ->dispatchOrderLineStateOnChangeEvent(
                $order,
                $orderLine,
                $lastOrderLineHistory,
                $orderLineHistory,
                $newState
            );

        return $this;
    }

    /**
     * Given existent OrderLine, checks if new state is reachable
     *
     * @param OrderLineInterface $orderLine Orderline object
     * @param String             $newState  New state to append
     *
     * @return boolean OrderLine can change to desired state
     */
    public function checkOrderLineCanChangeToState(
        OrderLineInterface $orderLine,
        $newState
    )
    {
        $lastState = $orderLine
            ->getLastOrderLineHistory()
            ->getState();

        return $this
            ->orderStateManager
            ->isOrderStateChangePermitted(
                $lastState,
                $newState
            );
    }
}
