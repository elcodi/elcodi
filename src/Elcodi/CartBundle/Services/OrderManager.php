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

use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Exception\OrderLineStateChangeNotReachableException;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\ElcodiCartEvents;
use Elcodi\CartBundle\Event\OrderOnCreatedEvent;
use Elcodi\CartBundle\Event\OrderPostCreatedEvent;
use Elcodi\CartBundle\Event\OrderPreCreatedEvent;
use Elcodi\CartBundle\Factory\OrderFactory;
use Elcodi\CartBundle\Repository\OrderRepository;
use Elcodi\CoreBundle\Generator\RandomStringGenerator;
use Elcodi\CartBundle\Exception\OrderStateChangeNotAllowedException;
use Elcodi\CartBundle\Exception\OrderStateChangeNotReachableException;

/**
 * Order manager service
 *
 * This service allow user to manage orders
 * Also allow user to create new order given a Cart
 */
class OrderManager
{
    /**
     * @var ObjectManager
     *
     * Manager
     */
    protected $manager;

    /**
     * @var OrderLineManager
     *
     * OrderLineManager instance
     */
    protected $orderLineManager;

    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcherInterface instance
     */
    protected $eventDispatcher;

    /**
     * @var RandomStringGenerator
     *
     * Random string generator
     */
    protected $randomStringGenerator;

    /**
     * @var OrderRepository
     *
     * Order repository
     */
    protected $orderRepository;

    /**
     * @var OrderFactory
     *
     * Order factory
     */
    protected $orderFactory;

    /**
     * @var array
     *
     * Available changeset for order history lines
     */
    protected $orderHistoryChangesAvailable;

    /**
     * Construct method
     *
     * @param ObjectManager            $manager                      Entity manager
     * @param EventDispatcherInterface $eventDispatcher              Event dispatcher
     * @param OrderLineManager         $orderLineManager             OrderLineManager instance
     * @param OrderRepository          $orderRepository              OrderRepository
     * @param OrderFactory             $orderFactory                 OrderFactory
     * @param array                    $orderHistoryChangesAvailable Order History changes Available
     */
    public function __construct(
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        OrderLineManager $orderLineManager,
        OrderRepository $orderRepository,
        OrderFactory $orderFactory,
        array $orderHistoryChangesAvailable
    )
    {
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
        $this->orderLineManager = $orderLineManager;
        $this->orderRepository = $orderRepository;
        $this->orderFactory = $orderFactory;
        $this->orderHistoryChangesAvailable = $orderHistoryChangesAvailable;
    }

    /**
     * This method creates a Order given a Cart.
     * If already exists an Order with given Cart, this Order is taken as valid.
     *
     * This method dispatches these events
     *
     * ElcodiPurchaseEvents::ORDER_PRECREATED
     * ElcodiPurchaseEvents::ORDER_ONCREATED
     * ElcodiPurchaseEvents::ORDER_POSTCREATED
     *
     * @param CartInterface $cart Cart to create order from
     *
     * @return OrderInterface the created order
     */
    public function createOrderFromCart(CartInterface $cart)
    {
        /**
         * Dispatch before order created event
         */
        $orderPreCreatedEvent = new OrderPreCreatedEvent($cart);
        $this->eventDispatcher->dispatch(ElcodiCartEvents::ORDER_PRECREATED, $orderPreCreatedEvent);

        $previousOrder = $this->orderRepository->findOneBy(array(
            'cart' => $cart
        ));

        $order = $previousOrder instanceof OrderInterface
            ? $previousOrder
            : $this->orderFactory->create();
        $this->manager->persist($order);

        $cart
            ->setOrder($order)
            ->setOrdered(true);

        $order
            ->setCustomer($cart->getCustomer())
            ->setCart($cart)
            ->setQuantity($cart->getQuantity())
            ->setProductAmount($cart->getProductAmount())
            ->setAmount($cart->getAmount());

        /**
         * @var CartLineInterface $line
         */
        foreach ($cart->getCartLines() as $cartLine) {

            $orderLine = $this->orderLineManager->createOrderLineByCartLine($order, $cartLine);
            $order->addOrderLine($orderLine);
        }

        /**
         * Dispatch on order created event
         */
        $orderOnCreatedEvent = new OrderOnCreatedEvent($cart, $order);
        $this->eventDispatcher->dispatch(ElcodiCartEvents::ORDER_ONCREATED, $orderOnCreatedEvent);

        /**
         * Flush all order
         */
        $this->manager->flush($order);

        /**
         * Dispatch after order created event
         */
        $orderPostCreatedEvent = new OrderPostCreatedEvent($cart, $order);
        $this->eventDispatcher->dispatch(ElcodiCartEvents::ORDER_POSTCREATED, $orderPostCreatedEvent);

        return $order;
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
     * @throws OrderStateChangeNotAllowedException   Stat change not reachable by almost one of OrderLines
     * @throws OrderStateChangeNotReachableException New stat not reachable by order
     */
    public function toState(OrderInterface $order, $state)
    {
        $this->checkChangeToState($order, $state);

        $order->getOrderLines()->map(function ($orderLine) use ($order, $state) {

            $this->orderLineManager->toState($order, $orderLine, $state);
        });

        return $this;
    }

    /**
     * Given existent Order, returns if go to new state is permitted.
     *
     * @param OrderInterface $order Order
     * @param string         $state New state
     *
     * @return OrderManager self Object
     *
     * @throws OrderStateChangeNotAllowedException   Stat change not reachable by almost one of OrderLines
     * @throws OrderStateChangeNotReachableException New stat not reachable by order
     */
    public function checkChangeToState(OrderInterface $order, $state)
    {
        $lastOrderHistoryState = $order->getLastOrderHistory();

        try {
            $this->isChangePermitted($lastOrderHistoryState, $state);
            $order->getOrderLines()->forAll(function ($_, $orderLine) use ($state) {

                $this->orderLineManager->checkChangeToState($orderLine, $state);
            });
        } catch (OrderLineStateChangeNotReachableException $exception) {

            throw new OrderStateChangeNotAllowedException;
        }

        return $this;
    }

    /**
     * Checks if current change is permitted. If not, this method throws
     * exception
     *
     * Change is permitted
     *
     * @param OrderHistoryInterface $lastOrderHistory Last order line history
     * @param string                $newState         New state
     *
     * @return boolean Change can be done
     *
     * @throws OrderStateChangeNotReachableException
     */
    protected function isChangePermitted(OrderHistoryInterface $lastOrderHistory, $newState)
    {
        /**
         * $lastState - Current line state
         * $newState - New Stat to reach
         */
        $lastState = $lastOrderHistory->getState();
        $availableStats = array_key_exists($lastState, $this->orderHistoryChangesAvailable)
            ? $this->orderHistoryChangesAvailable[$lastState]
            : array();

        if (($lastState == $newState) && !in_array($newState, $availableStats)) {

            /**
             * nothing to do. If it's in the array this means we want to record
             * repeated states.
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

            throw new OrderStateChangeNotReachableException(
                "From $lastState you cannot go to $newState, only to " .
                implode(',', $this->orderHistoryChangesAvailable[$lastState])
            );
        }

        return true;
    }
}
