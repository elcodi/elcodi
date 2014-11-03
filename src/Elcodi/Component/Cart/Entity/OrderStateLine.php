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

namespace Elcodi\Component\Cart\Entity;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderStateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLine;

/**
 * Class OrderStateLine
 */
class OrderStateLine extends StateLine implements OrderStateLineInterface
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * Get Order
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets Order
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }
}
