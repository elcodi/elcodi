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

namespace Elcodi\Component\Cart\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;

/**
 * Class AbstractOrderEvent.
 */
abstract class AbstractOrderEvent extends Event
{
    /**
     * @var CartInterface
     *
     * cart
     */
    private $cart;

    /**
     * @var OrderInterface
     *
     * Order
     */
    private $order;

    /**
     * construct method.
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order Order
     */
    public function __construct(
        CartInterface $cart,
        OrderInterface $order
    ) {
        $this->cart = $cart;
        $this->order = $order;
    }

    /**
     * Get cart.
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Return order.
     *
     * @return OrderInterface Order stored
     */
    public function getOrder()
    {
        return $this->order;
    }
}
