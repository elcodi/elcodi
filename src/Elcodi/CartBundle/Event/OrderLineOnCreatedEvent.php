<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;

/**
 * Class OrderLineOnCreatedEvent
 */
class OrderLineOnCreatedEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var CartLineInterface
     *
     * cartLine
     */
    protected $cartLine;

    /**
     * @var OrderLineInterface
     *
     * OrderLine
     */
    protected $orderLine;

    /**
     * construct method
     *
     * @param OrderInterface     $order     Order line
     * @param CartLineInterface  $cartLine  Cart line
     * @param OrderLineInterface $orderLine OrderLine
     */
    public function __construct(
        OrderInterface $order,
        CartLineInterface $cartLine,
        OrderLineInterface $orderLine
    )
    {
        $this->order = $order;
        $this->cartLine = $cartLine;
        $this->orderLine = $orderLine;
    }

    /**
     * Get order
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Get cartLine
     *
     * @return CartLineInterface Cart Line
     */
    public function getCartLine()
    {
        return $this->cartLine;
    }

    /**
     * Get cartLine
     *
     * @return OrderLineInterface|null Cart Line
     */
    public function getOrderLine()
    {
        return $this->orderLine;
    }
}
