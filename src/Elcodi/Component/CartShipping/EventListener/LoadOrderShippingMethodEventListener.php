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

namespace Elcodi\Component\CartShipping\EventListener;

use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;
use Elcodi\Component\CartShipping\Services\OrderShippingMethodLoader;

/**
 * Class LoadOrderShippingMethodEventListener.
 */
final class LoadOrderShippingMethodEventListener
{
    /**
     * @var OrderShippingMethodLoader
     *
     * Order shipping method loader
     */
    private $orderShippingMethodLoader;

    /**
     * Construct.
     *
     * @param OrderShippingMethodLoader $orderShippingMethodLoader Order shipping method loader
     */
    public function __construct(OrderShippingMethodLoader $orderShippingMethodLoader)
    {
        $this->orderShippingMethodLoader = $orderShippingMethodLoader;
    }

    /**
     * Load cart shipping amount.
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function loadOrderShippingMethod(OrderOnCreatedEvent $event)
    {
        $this
            ->orderShippingMethodLoader
            ->loadOrderShippingMethod(
                $event->getCart(),
                $event->getOrder()
            );
    }
}
