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

use Elcodi\Component\Cart\Event\OrderLineOnCreatedEvent;
use Elcodi\Component\Cart\Services\CartLineStockUpdater;

/**
 * Class UpdateStockByCartLineEventListener.
 */
final class UpdateStockByCartLineEventListener
{
    /**
     * @var CartLineStockUpdater
     *
     * Cartline stock updater
     */
    private $cartLineStockUpdater;

    /**
     * Built method.
     *
     * @param CartLineStockUpdater $cartLineStockUpdater Cartline stock updater
     */
    public function __construct(CartLineStockUpdater $cartLineStockUpdater)
    {
        $this->cartLineStockUpdater = $cartLineStockUpdater;
    }

    /**
     * Performs all processes to be performed after the order creation.
     *
     * Flushes all loaded order and related entities.
     *
     * @param OrderLineOnCreatedEvent $event Event
     */
    public function updatePurchasableStockByCartLine(OrderLineOnCreatedEvent $event)
    {
        $this
            ->cartLineStockUpdater
            ->updatePurchasableStockByCartLine(
                $event->getCartLine()
            );
    }
}
