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

namespace Elcodi\Component\Cart\Entity;

use Elcodi\Component\Cart\Entity\Abstracts\AbstractHistory;
use Elcodi\Component\Cart\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;

/**
 * OrderHistory
 */
class OrderHistory extends AbstractHistory implements OrderHistoryInterface
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * Set the order
     *
     * @param OrderInterface $order Order to set
     *
     * @return OrderHistory self Object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the order
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
