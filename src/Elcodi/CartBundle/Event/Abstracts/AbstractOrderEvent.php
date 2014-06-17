<?php

/**
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
 */

namespace Elcodi\CartBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;

/**
 * Class AbstractOrderEvent
 */
abstract class AbstractOrderEvent extends Event
{
    /**
     * @var CartInterface
     *
     * cart
     */
    protected $cart;

    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * construct method
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order The order created
     */
    public function __construct(
        CartInterface $cart,
        OrderInterface $order
    )
    {
        $this->cart = $cart;
        $this->order = $order;
    }

    /**
     * Get cart
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Return order stored
     *
     * @return OrderInterface Order stored
     */
    public function getOrder()
    {
        return $this->order;
    }
}
