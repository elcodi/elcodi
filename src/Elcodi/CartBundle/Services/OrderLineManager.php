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

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Event\OrderLineOnCreatedEvent;
use Elcodi\CartBundle\Event\OrderLinePostCreatedEvent;
use Elcodi\CartBundle\Event\OrderLinePreCreatedEvent;
use Elcodi\CartBundle\Factory\OrderLineFactory;
use Elcodi\CartBundle\ElcodiCartEvents;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Event\OrderLineStatePostChangeEvent;
use Elcodi\CartBundle\Factory\OrderLineHistoryFactory;
use Elcodi\CartBundle\Event\OrderLineStatePreChangeEvent;
use Elcodi\CartBundle\Exception\OrderLineStateChangeNotReachableException;

/**
 * Order Line History manager
 */
class OrderLineManager
{
    /**
     * @var ObjectManager
     *
     * Manager
     */
    protected $manager;

    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcherInterface instance
     */
    protected $eventDispatcher;

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
     * @var array
     *
     * Available changeset for order history lines
     */
    protected $orderHistoryChangesAvailable;

    /**
     * Construct method
     *
     * @param ObjectManager            $manager                      Entity Manager
     * @param EventDispatcherInterface $eventDispatcher              Event Dispatcher
     * @param OrderLineHistoryFactory  $orderLineHistoryFactory      Order line history factory
     * @param OrderLineFactory         $orderLineFactory             OrderLineFactory
     * @param array                    $orderHistoryChangesAvailable Order History changes Available
     */
    public function __construct(
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        OrderLineHistoryFactory $orderLineHistoryFactory,
        OrderLineFactory $orderLineFactory,
        array $orderHistoryChangesAvailable
    )
    {
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
        $this->orderLineHistoryFactory = $orderLineHistoryFactory;
        $this->orderLineFactory = $orderLineFactory;
        $this->orderHistoryChangesAvailable = $orderHistoryChangesAvailable;
    }

    /**
     * Given a cart line, create new order line
     *
     * @param OrderInterface    $order    Order
     * @param CartLineInterface $cartLine Cart Line
     *
     * @return OrderLineInterface OrderLine created
     */
    public function createOrderLineByCartLine(OrderInterface $order, CartLineInterface $cartLine)
    {
        /**
         * Dispatch before order created event
         */
        $orderPreCreatedEvent = new OrderLinePreCreatedEvent($order, $cartLine);
        $this->eventDispatcher->dispatch(ElcodiCartEvents::ORDER_PRECREATED, $orderPreCreatedEvent);

        /**
         * @var OrderLineInterface $orderLine
         */
        $orderLine = $this->orderLineFactory->create();
        $this->manager->persist($orderLine);
        $orderLine
            ->setOrder($order)
            ->setProduct($cartLine->getProduct())
            ->setQuantity($cartLine->getQuantity())
            ->setPriceProducts($cartLine->getPriceProducts())
            ->setPriceCoupons($cartLine->getPriceCoupons())
            ->setPrice($cartLine->getPrice());

        $orderOnCreatedEvent = new OrderLineOnCreatedEvent($order, $cartLine, $orderLine);
        $this->eventDispatcher->dispatch(ElcodiCartEvents::ORDER_ONCREATED, $orderOnCreatedEvent);

        $orderPostCreatedEvent = new OrderLinePostCreatedEvent($order, $cartLine, $orderLine);
        $this->eventDispatcher->dispatch(ElcodiCartEvents::ORDER_POSTCREATED, $orderPostCreatedEvent);

        return $orderLine;
    }

    /**
     * Given existent OrderLine appends new state entry. Because this method
     * calls all events, developer must ensure first that this change is
     * permited. Otherwise, some events will be dispatched and Exception will
     * be thrown.
     *
     * This methods dispatches OrderLineState change
     *
     * @param OrderInterface     $order     Order
     * @param OrderLineInterface $orderLine Orderline object
     * @param String             $newState  New state to append
     *
     * @return OrderLineManager self Object
     *
     * @throws OrderLineStateChangeNotReachableException
     */
    public function toState(
        OrderInterface $order,
        OrderLineInterface $orderLine,
        $newState
    )
    {
        $lastOrderLineHistory = $orderLine->getOrderLineHistories()->last();

        /**
         * Dispatching common pre State changed event...
         *
         * This event not contains new generated OrderLineHistory instance
         * because is not generated yet.
         */
        $orderLineStatePreChangeEvent = new OrderLineStatePreChangeEvent(
            $order,
            $orderLine,
            $lastOrderLineHistory
        );
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDERLINE_STATE_PRECHANGE,
            $orderLineStatePreChangeEvent
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

        $this->manager->persist($orderLineHistory);
        $this->manager->flush($orderLineHistory);

        /**
         * Dispatching common State changed event...
         *
         * This event contains new generated OrderLineHistory instance because
         * is already defined
         */
        $orderLineStatePostChangeEvent = new OrderLineStatePostChangeEvent(
            $order,
            $orderLine,
            $lastOrderLineHistory,
            $orderLineHistory
        );
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::ORDERLINE_STATE_POSTCHANGE,
            $orderLineStatePostChangeEvent
        );

        return $this;
    }

    /**
     * Given existent OrderLine, checks if new state is reachable
     *
     * @param OrderLineInterface $orderLine Orderline object
     * @param String             $newState  New state to append
     *
     * @return OrderLineManager self Object
     */
    public function checkChangeToState(OrderLineInterface $orderLine, $newState)
    {
        $lastOrderLineHistory = $orderLine->getOrderLineHistories()->last();
        $this->isChangePermited($lastOrderLineHistory, $newState);

        return $this;
    }

    /**
     * Checks if current change is permitted. If not, this method throws
     * exception
     *
     * Change is permited
     *
     * @param OrderLineHistoryInterface $lastOrderLineHistory Last order line history
     * @param string                    $newState             New state
     *
     * @return boolean Change can be done
     *
     * @throws OrderLineStateChangeNotReachableException
     */
    protected function isChangePermited(OrderLineHistoryInterface $lastOrderLineHistory, $newState)
    {
        /**
         * $lastState - Current line state
         * $newState - New Stat to reach
         */
        $lastState = $lastOrderLineHistory->getState();
        $availableStats = array_key_exists($lastState, $this->orderHistoryChangesAvailable)
            ? $this->orderHistoryChangesAvailable[$lastState]
            : array();

        if (($lastState == $newState) && !in_array($newState, $availableStats)) {

            /**
             * nothing to do. If it's in the array this means we want to record
             * repeated states
             *
             * Return false because any effect will cause.
             */
            return false;
        }

        /**
         * Exception if new state is not available nor is accessible from
         * current state
         */
        if (!in_array($newState, $availableStats)) {

            throw new OrderLineStateChangeNotReachableException(
                "From $lastState you cannot go to $newState, only to " .
                implode(',', $this->orderHistoryChangesAvailable[$lastState])
            );
        }

        return true;
    }
}
