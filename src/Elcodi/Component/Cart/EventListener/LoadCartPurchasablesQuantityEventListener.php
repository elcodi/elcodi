<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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
use Elcodi\Component\Cart\Services\CartPurchasablesQuantityLoader;

/**
 * Class LoadCartPurchasablesQuantityEventListener.
 */
final class LoadCartPurchasablesQuantityEventListener
{
    /**
     * @var CartPurchasablesQuantityLoader
     *
     * Cart purchasables quantity loader
     */
    private $cartPurchasablesQuantityLoader;

    /**
     * Construct.
     *
     * @param CartPurchasablesQuantityLoader $cartPurchasablesQuantityLoader Cart purchasables quantity loader
     */
    public function __construct(CartPurchasablesQuantityLoader $cartPurchasablesQuantityLoader)
    {
        $this->cartPurchasablesQuantityLoader = $cartPurchasablesQuantityLoader;
    }

    /**
     * Load cart purchasables quantity.
     */
    public function loadCartPurchasablesQuantities(CartOnLoadEvent $event)
    {
        $this
            ->cartPurchasablesQuantityLoader
            ->loadCartPurchasablesQuantities(
                $event->getCart()
            );
    }
}
