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

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\CartShipping\Services\CartShippingAmountLoader;

/**
 * Class LoadCartShippingAmountEventListener.
 */
final class LoadCartShippingAmountEventListener
{
    /**
     * @var CartShippingAmountLoader
     *
     * Cart shipping amount loader
     */
    private $cartShippingAmountLoader;

    /**
     * Construct.
     *
     * @param CartShippingAmountLoader $cartShippingAmountLoader Cart shipping amount loader
     */
    public function __construct(CartShippingAmountLoader $cartShippingAmountLoader)
    {
        $this->cartShippingAmountLoader = $cartShippingAmountLoader;
    }

    /**
     * Load cart shipping amount.
     *
     * @param CartOnLoadEvent $event Event
     */
    public function loadCartShippingAmount(CartOnLoadEvent $event)
    {
        $this
            ->cartShippingAmountLoader
            ->loadCartShippingAmount(
                $event->getCart()
            );
    }
}
