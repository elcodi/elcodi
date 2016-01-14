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

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\CartCoupon\Event\Abstracts\AbstractCartCouponEvent;

/**
 * Class CartUpdateAfterCouponChangeEventListener.
 */
class CartUpdateAfterCouponChangeEventListener
{
    /**
     * @var CartEventDispatcher
     *
     * Cart event dispatcher
     */
    private $cartEventDispatcher;

    /**
     * Construct.
     *
     * @param CartEventDispatcher $cartEventDispatcher Cart event dispatcher
     */
    public function __construct(CartEventDispatcher $cartEventDispatcher)
    {
        $this->cartEventDispatcher = $cartEventDispatcher;
    }

    /**
     * Update cart after a success addition.
     *
     * @param AbstractCartCouponEvent $event Event
     */
    public function updateCart(AbstractCartCouponEvent $event)
    {
        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents(
                $event->getCart()
            );
    }
}
