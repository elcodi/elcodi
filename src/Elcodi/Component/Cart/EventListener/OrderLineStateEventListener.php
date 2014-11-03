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

namespace Elcodi\Component\Cart\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Event\OrderLineStateOnChangeEvent;
use Elcodi\Component\Cart\EventDispatcher\OrderStateEventDispatcher;
use Elcodi\Component\Cart\Factory\OrderHistoryFactory;

/**
 * Class OrderLineStateEventListener
 */
class OrderLineStateEventListener
{
    /**
     * @var ObjectManager
     *
     * OrderLine ObjectManager
     */
    protected $orderLineObjectManager;

    /**
     * @var OrderStateEventDispatcher
     *
     * Order State Event dispatcher
     */
    protected $orderStateEventDispatcher;

    /**
     * @var OrderHistoryFactory
     *
     * OrderHistory Factory
     */
    protected $orderHistoryFactory;

    /**
     * Construct method
     *
     * @param ObjectManager             $orderLineObjectManager    OrderLine ObjectManager
     * @param OrderStateEventDispatcher $orderStateEventDispatcher Order State Event dispatcher
     * @param OrderHistoryFactory       $orderHistoryFactory       OrderHistory Factory
     */
    public function __construct(
        ObjectManager $orderLineObjectManager,
        OrderStateEventDispatcher $orderStateEventDispatcher,
        OrderHistoryFactory $orderHistoryFactory
    )
    {
        $this->orderLineObjectManager = $orderLineObjectManager;
        $this->orderStateEventDispatcher = $orderStateEventDispatcher;
        $this->orderHistoryFactory = $orderHistoryFactory;
    }

    /**
     * Subscribed on OrderLineState post change event
     *
     * This listener checks if full Order has to change its event, given the
     * OrderLines states
     *
     * @param OrderLineStateOnChangeEvent $event Event
     */
    public function onOrderLineStateChange(OrderLineStateOnChangeEvent $event)
    {
        $order = $event->getOrder();

        /**
         * If all cartLines are in same state, and last state is not same, add new line.
         */
        $newState = null;

        /**
         * @var OrderLineInterface $line
         */
        foreach ($order->getOrderLines() as $line) {

            $lastOrderLineHistory = $line->getLastOrderLineHistory();
            $lastState = "";

            if ($lastOrderLineHistory instanceof OrderLineHistoryInterface) {
                $lastState = $lastOrderLineHistory->getState();
            }

            if (null === $newState) {
                $newState = $lastState;

            } elseif ($newState !== $lastState) {
                /**
                 * not all lines in the same state
                 */

                return;
            }
        }

        // All order lines are in same state.
        $lastOrderHistory = $order->getLastOrderHistory() instanceof OrderHistoryInterface
            ? $order->getLastOrderHistory()
            : $this->orderHistoryFactory->create();

        $this
            ->orderStateEventDispatcher
            ->dispatchOrderStatePreChangeEvent(
                $order,
                $lastOrderHistory,
                $newState
            );

        /**
         * @var OrderHistoryInterface $orderHistory
         */
        $orderHistory = $this->orderHistoryFactory->create();
        $orderHistory
            ->setState($newState)
            ->setOrder($order);

        $order
            ->addOrderHistory($orderHistory)
            ->setLastOrderHistory($orderHistory);

        $this
            ->orderStateEventDispatcher
            ->dispatchOrderStateOnChangeEvent(
                $order,
                $lastOrderHistory,
                $orderHistory,
                $newState
            );
    }

    /**
     * Flushes OrderLine. New State has added to the object
     *
     * @param OrderLineStateOnChangeEvent $event Event
     */
    public function onOrderLineStateChangeFlush(OrderLineStateOnChangeEvent $event)
    {
        $order = $event->getOrder();

        $this
            ->orderLineObjectManager
            ->persist($order);

        $this
            ->orderLineObjectManager
            ->flush();
    }
}
