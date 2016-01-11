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

namespace Elcodi\Component\Shipping\EventDispatcher;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Shipping\ElcodiShippingEvents;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Event\ShippingCollectionEvent;

/**
 * Class ShippingEventDispatcher.
 */
class ShippingEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch shipping methods collection.
     *
     * @param CartInterface $cart Cart
     *
     * @return ShippingMethod[] Shipping methods
     */
    public function dispatchShippingCollectionEvent(CartInterface $cart)
    {
        $event = new ShippingCollectionEvent($cart);

        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiShippingEvents::SHIPPING_COLLECT,
                $event
            );

        return $event->getShippingMethods();
    }
}
