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
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;

/**
 * OrderLineHistory entity
 */
class OrderLineHistory extends AbstractHistory implements OrderLineHistoryInterface
{
    /**
     * @var OrderLineInterface
     *
     * Order line
     */
    protected $orderLine;

    /**
     * Set order line
     *
     * @param OrderLineInterface $orderLine Order Line
     *
     * @return $this self Object
     */
    public function setOrderLine(OrderLineInterface $orderLine)
    {
        $this->orderLine = $orderLine;

        return $this;
    }

    /**
     * Get the order line
     *
     * @return OrderLineInterface
     */
    public function getOrderLine()
    {
        return $this->orderLine;
    }

    /**
     * String representation of entity
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getState();
    }
}
