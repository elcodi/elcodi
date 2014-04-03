<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Entity\Abstracts\AbstractLine;

/**
 * OrderLine
 *
 * This entity is just an extension of existant order line with some aditional
 * parameters
 */
class OrderLine extends AbstractLine implements OrderLineInterface
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * @var Collection
     *
     * Order histories
     */
    protected $orderLineHistories;

    /**
     * @var OrderLineHistoryInterface
     *
     * Last OrderLineHistory
     */
    protected $lastOrderLineHistory;

    /**
     * Set Order
     *
     * @param OrderInterface $order Order
     *
     * @return OrderLine self Object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
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
     * Set order line histories
     *
     * @param Collection $orderLineHistories Order histories
     *
     * @return OrderLine self Object
     */
    public function setOrderLineHistories(Collection $orderLineHistories)
    {
        $this->orderLineHistories = $orderLineHistories;

        return $this;
    }

    /**
     * Get order line histories
     *
     * @return Collection Order Line histories
     */
    public function getOrderLineHistories()
    {
        return $this->orderLineHistories;
    }

    /**
     * Add Order History
     *
     * @param OrderLineHistoryInterface $orderLineHistory Order History
     *
     * @return OrderLine self Object
     */
    public function addOrderLineHistory(OrderLineHistoryInterface $orderLineHistory)
    {
        $this->orderLineHistories->add($orderLineHistory);

        return $this;
    }

    /**
     * Remove Order History
     *
     * @param OrderLineHistoryInterface $orderLineHistory Order Line History
     *
     * @return OrderLine self Object
     */
    public function removeOrderLineHistory(OrderLineHistoryInterface $orderLineHistory)
    {
        $this->orderLineHistories->removeElement($orderLineHistory);

        return $this;
    }

    /**
     * Sets LastOrderLineHistory
     *
     * @param OrderLineHistoryInterface $lastOrderLineHistory LastOrderLineHistory
     *
     * @return OrderLine Self object
     */
    public function setLastOrderLineHistory(OrderLineHistoryInterface $lastOrderLineHistory)
    {
        $this->lastOrderLineHistory = $lastOrderLineHistory;

        return $this;
    }

    /**
     * Get LastOrderLineHistory
     *
     * @return OrderLineHistoryInterface LastOrderLineHistory
     */
    public function getLastOrderLineHistory()
    {
        return $this->lastOrderLineHistory;
    }
}
