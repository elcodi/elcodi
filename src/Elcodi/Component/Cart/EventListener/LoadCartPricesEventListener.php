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

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Cart\Services\CartPricesLoader;

/**
 * Class LoadCartPricesEventListener.
 */
final class LoadCartPricesEventListener
{
    /**
     * @var CartPricesLoader
     *
     * Cart prices loader
     */
    private $cartPricesLoader;

    /**
     * Construct.
     *
     * @param CartPricesLoader $cartPricesLoader Cart prices loader
     */
    public function __construct(CartPricesLoader $cartPricesLoader)
    {
        $this->cartPricesLoader = $cartPricesLoader;
    }

    /**
     * Load cart purchasable amount.
     */
    public function loadCartPurchasablesAmount(CartOnLoadEvent $event)
    {
        $this
            ->cartPricesLoader
            ->loadCartPurchasablesAmount(
                $event->getCart()
            );
    }

    /**
     * Load cart total amount.
     */
    public function loadCartTotalAmount(CartOnLoadEvent $event)
    {
        $this
            ->cartPricesLoader
            ->loadCartTotalAmount(
                $event->getCart()
            );
    }
}
