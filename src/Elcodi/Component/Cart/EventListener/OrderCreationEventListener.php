<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Cart\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;

/**
 * Class OrderCreationEventListener.
 *
 * These event listeners are supposed to be used when an Order is created given
 * a Cart
 *
 * Public methods:
 *
 * * saveOrder
 * * setCartAsOrdered
 */
final class OrderCreationEventListener
{
    /**
     * @var ObjectManager
     *
     * ObjectManager for Order entity
     */
    private $orderObjectManager;

    /**
     * @var ObjectManager
     *
     * ObjectManager for Cart entity
     */
    private $cartObjectManager;

    /**
     * Built method.
     *
     * @param ObjectManager $orderObjectManager ObjectManager for Order entity
     * @param ObjectManager $cartObjectManager  ObjectManager for Cart entity
     */
    public function __construct(
        ObjectManager $orderObjectManager,
        ObjectManager $cartObjectManager
    ) {
        $this->orderObjectManager = $orderObjectManager;
        $this->cartObjectManager = $cartObjectManager;
    }

    /**
     * Performs all processes to be performed after the order creation.
     *
     * Flushes all loaded order and related entities.
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function saveOrder(OrderOnCreatedEvent $event)
    {
        $order = $event->getOrder();

        $this->orderObjectManager->persist($order);
        $this->orderObjectManager->flush($order);
    }

    /**
     * After an Order is created, the cart is set as Ordered enabling related
     * flag.
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function setCartAsOrdered(OrderOnCreatedEvent $event)
    {
        $cart = $event
            ->getCart()
            ->setOrdered(true);

        $this->cartObjectManager->flush($cart);
    }
}
