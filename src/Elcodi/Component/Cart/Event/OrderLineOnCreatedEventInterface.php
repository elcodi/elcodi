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

namespace Elcodi\Component\Cart\Event;

use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;

/**
 * Interface OrderLineOnCreatedEventInterface
 */
interface OrderLineOnCreatedEventInterface
{
    /**
     * Get order
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * Get cartLine
     *
     * @return CartLineInterface Cart Line
     */
    public function getCartLine();

    /**
     * Get cartLine
     *
     * @return OrderLineInterface Order Line
     */
    public function getOrderLine();
}
