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

use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;

/**
 * Class OrderMachineEventListener
 */
class OrderMachineEventListener
{
    /**
     * @var ObjectManager
     *
     * Order StateLine Object Manager
     */
    protected $orderStateLineObjectManager;

    /**
     * Construct method
     *
     * @param ObjectManager $orderStateLineObjectManager Order StateLine Object Manager
     */
    public function __construct(ObjectManager $orderStateLineObjectManager)
    {
        $this->orderStateLineObjectManager = $orderStateLineObjectManager;
    }

    /**
     * Initialises the Order given a StateTransitionMachine
     *
     * @param OrderOnCreatedEvent $orderOnCreatedEvent Event
     */
    public function onOrderCreated(OrderOnCreatedEvent $orderOnCreatedEvent)
    {
        $stateLine = $orderOnCreatedEvent
            ->getOrder()
            ->getLastStateLine();

        $this->orderStateLineObjectManager->persist($stateLine);
        $this->orderStateLineObjectManager->flush($stateLine);
    }
}
