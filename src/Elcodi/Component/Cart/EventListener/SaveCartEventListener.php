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

use Elcodi\Component\Cart\Event\Abstracts\AbstractCartEvent;
use Elcodi\Component\Cart\Services\CartSaver;

/**
 * Class SaveCartEventListener.
 */
final class SaveCartEventListener
{
    /**
     * @var CartSaver
     *
     * Cart prices loader
     */
    private $cartSaver;

    /**
     * Construct.
     *
     * @param CartSaver $cartSaver Cart prices loader
     */
    public function __construct(CartSaver $cartSaver)
    {
        $this->cartSaver = $cartSaver;
    }

    /**
     * Save cart.
     *
     * @param AbstractCartEvent $event Event
     */
    public function saveCart(AbstractCartEvent $event)
    {
        $this
            ->cartSaver
            ->saveCart(
                $event->getCart()
            );
    }
}
