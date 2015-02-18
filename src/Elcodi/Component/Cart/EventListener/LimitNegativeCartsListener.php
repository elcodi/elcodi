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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Cart\EventListener;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;

/**
 * Class LimitNegativeCartsListener
 *
 * @author Berny Cantos <be@rny.cc>
 */
class LimitNegativeCartsListener
{
    /**
     * When a cart goes below 0 (due to discounts), set the amount to 0.
     *
     * @param CartOnLoadEvent $event Event
     */
    public function limitCartAmount(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        $amount = $cart->getAmount();

        if ($amount->getAmount() <= 0) {
            $cart->setAmount($amount->setAmount(0));
        }
    }
}
