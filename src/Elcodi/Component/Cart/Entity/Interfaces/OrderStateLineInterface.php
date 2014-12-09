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
 */

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;

/**
 * Interface OrderStateLineInterface
 */
interface OrderStateLineInterface extends StateLineInterface
{
    /**
     * Get Order
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * Sets Order
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order);
}
