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

namespace Elcodi\CartBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CartBundle\Event\OrderOnCreatedEvent;

/**
 * Class OrderEventListener
 */
class OrderEventListener
{
    /**
     * @var ObjectManager
     *
     * ObjectManager for Order entity
     */
    protected $orderObjectManager;

    /**
     * Built method
     *
     * @param ObjectManager $orderObjectManager ObjectManager for Order entity
     */
    public function __construct(
        ObjectManager $orderObjectManager
    )
    {
        $this->orderObjectManager = $orderObjectManager;
    }

    /**
     * Performs all processes to be performed after the order creation
     *
     * Flushes all loaded order and related entities.
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function onOrderCreated(OrderOnCreatedEvent $event)
    {
        $order = $event->getOrder();

        $this->orderObjectManager->persist($order);
        $this->orderObjectManager->flush();
    }
}
