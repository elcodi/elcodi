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

namespace Elcodi\CartBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\CartBundle\ElcodiCartEvents;
use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Event\OrderLineStatePostChangeEvent;
use Elcodi\CartBundle\Event\OrderStatePostChangeEvent;
use Elcodi\CartBundle\Event\OrderStatePreChangeEvent;
use Elcodi\CartBundle\Factory\OrderHistoryFactory;

/**
 * Class OrderLineStateEventListener
 */
class OrderLineStateEventListener
{
    /**
     * @var ObjectManager
     *
     * Object manager
     */
    protected $manager;

    /**
     * @var EventDispatcherInterface
     *
     * Event dispatcher
     */
    protected $eventDispatcher;

    /**
     * @var OrderHistoryFactory
     *
     * OrderHistory Factory
     */
    protected $orderHistoryFactory;

    /**
     * Construct method
     *
     * @param ObjectManager            $manager             Manager
     * @param EventDispatcherInterface $eventDispatcher     Event dispatcher
     * @param OrderHistoryFactory      $orderHistoryFactory OrderHistory Factory
     */
    public function __construct(
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        OrderHistoryFactory $orderHistoryFactory
    )
    {
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
        $this->orderHistoryFactory = $orderHistoryFactory;
    }

    /**
     * Subscribed on OrderLineState post change event
     *
     * This listener checks if full Order has to change its event, given the
     * OrderLines states
     *
     * @param OrderLineStatePostChangeEvent $event Event
     */
    public function onOrderLineStatePostChange(OrderLineStatePostChangeEvent $event)
    {
        $order = $event->getOrder();

        /**
         * If all cartLines are in same state, and last state is not same, add new line.
         */
        $state = null;

        /**
         * @var OrderLineInterface $line
         */
        foreach ($order->getOrderLines() as $line) {

            $lastOrderLineHistory = $line->getLastOrderLineHistory();
            $lastState = "";

            if ($lastOrderLineHistory instanceof OrderLineHistoryInterface) {
                $lastState = $lastOrderLineHistory->getState();
            }

            if (null === $state) {
                $state = $lastState;

            } elseif ($state !== $lastState) {
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

        $orderStatePreChangeEvent = new OrderStatePreChangeEvent($order, $lastOrderHistory);
        $this->eventDispatcher->dispatch(ElcodiCartEvents::ORDER_STATE_PRECHANGE, $orderStatePreChangeEvent);

        /**
         * @var OrderHistoryInterface $orderHistory
         */
        $orderHistory = $this->orderHistoryFactory->create();
        $orderHistory
            ->setState($state)
            ->setOrder($order);

        $order
            ->addOrderHistory($orderHistory)
            ->setLastOrderHistory($orderHistory);

        $this->manager->persist($orderHistory);
        $this->manager->flush($orderHistory);
        $this->manager->flush($order);

        $orderStatePostChangeEvent = new OrderStatePostChangeEvent($order, $lastOrderHistory, $orderHistory);
        $this->eventDispatcher->dispatch(ElcodiCartEvents::ORDER_STATE_POSTCHANGE, $orderStatePostChangeEvent);
    }
}
