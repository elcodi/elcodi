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

namespace Elcodi\CartBundle\Services;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;

/**
 * Order manager service
 *
 * Manages all histories in specific Order
 *
 * Api Methods:
 *
 * * addStateToOrder(OrderInterface, $newState) : self
 * * checkOrderCanChangeToState(OrderInterface, $newState) : boolean
 */
class OrderManager
{
    /**
     * @var OrderLineManager
     *
     * OrderLineManager instance
     */
    protected $orderLineManager;

    /**
     * @var OrderStateManager
     *
     * OrderStateManager
     */
    protected $orderStateManager;

    /**
     * Construct method
     *
     * @param OrderLineManager  $orderLineManager  OrderLineManager instance
     * @param OrderStateManager $orderStateManager OrderStateManager
     */
    public function __construct(
        OrderLineManager $orderLineManager,
        OrderStateManager $orderStateManager
    )
    {
        $this->orderLineManager = $orderLineManager;
        $this->orderStateManager = $orderStateManager;
    }

    /**
     * This method puts all order lines (and order itself) to desired status
     *
     * If given state is same as actual Order state, will return with no action
     *
     * If state is reachable by the order, will check if all OrderLines can
     * reach desired state. If not, will return with no action.
     *
     * Otherwise, all lines will reach desired status, and EventListener
     * subscriber will also make Order reach desired state, dispatching all
     * defined events
     *
     * @param OrderInterface $order Order
     * @param string         $state The new state
     *
     * @return OrderManager self Object
     *
     * @api
     */
    public function addStateToOrder(
        OrderInterface $order,
        $state
    )
    {
        $order->getOrderLines()->map(function ($orderLine) use ($order, $state) {

            $this->orderLineManager->addStateToOrderLine($order, $orderLine, $state);
        });

        return $this;
    }

    /**
     * Given existent Order, returns if go to new state is permitted.
     *
     * @param OrderInterface $order Order
     * @param string         $state New state
     *
     * @return boolean Order can change to desired state
     *
     * @api
     */
    public function checkOrderCanChangeToState(
        OrderInterface $order,
        $state
    )
    {
        $lastOrderHistoryState = $order->getLastOrderHistory();

        if (!$this
            ->orderStateManager
            ->isOrderStateChangePermitted(
                $lastOrderHistoryState->getState(),
                $state
            )
        ) {
            return false;
        }

        return $order
            ->getOrderLines()
            ->forAll(function ($_, OrderLineInterface $orderLine) use ($state) {
                return $this
                    ->orderLineManager
                    ->checkOrderLineCanChangeToState(
                        $orderLine,
                        $state
                    );
            });
    }
}
