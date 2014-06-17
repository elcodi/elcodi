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

use Elcodi\CartBundle\Event\OrderStateOnChangeEvent;

/**
 * Class OrderStateEventListener
 */
class OrderStateEventListener
{
    /**
     * @var ObjectManager
     *
     * Order ObjectManager
     */
    protected $orderObjectManager;

    /**
     * Construct method
     *
     * @param ObjectManager $orderObjectManager Order ObjectManager
     */
    public function __construct(ObjectManager $orderObjectManager)
    {
        $this->orderObjectManager = $orderObjectManager;
    }

    /**
     * Flushes Order. New State has added to the object
     *
     * @param OrderStateOnChangeEvent $event Event
     */
    public function onOrderStateChangeFlush(OrderStateOnChangeEvent $event)
    {
        $order = $event->getOrder();

        $this
            ->orderObjectManager
            ->persist($order);

        $this
            ->orderObjectManager
            ->flush();
    }
}
