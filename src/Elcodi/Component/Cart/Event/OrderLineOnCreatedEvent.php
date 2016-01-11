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

namespace Elcodi\Component\Cart\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;

/**
 * Class OrderLineOnCreatedEvent.
 */
final class OrderLineOnCreatedEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    private $order;

    /**
     * @var CartLineInterface
     *
     * cartLine
     */
    private $cartLine;

    /**
     * @var OrderLineInterface
     *
     * OrderLine
     */
    private $orderLine;

    /**
     * construct method.
     *
     * @param OrderInterface     $order     Order line
     * @param CartLineInterface  $cartLine  Cart line
     * @param OrderLineInterface $orderLine OrderLine
     */
    public function __construct(
        OrderInterface $order,
        CartLineInterface $cartLine,
        OrderLineInterface $orderLine
    ) {
        $this->order = $order;
        $this->cartLine = $cartLine;
        $this->orderLine = $orderLine;
    }

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Get cartLine.
     *
     * @return CartLineInterface Cart Line
     */
    public function getCartLine()
    {
        return $this->cartLine;
    }

    /**
     * Get cartLine.
     *
     * @return OrderLineInterface Order Line
     */
    public function getOrderLine()
    {
        return $this->orderLine;
    }
}
