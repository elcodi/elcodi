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

namespace Elcodi\CartBundle\Event\Abstracts;

use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;

/**
 * Class AbstractOrderStateEvent
 */
class AbstractOrderStateEvent extends AbstractPurchaseEvent
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var OrderHistoryInterface
     *
     * Last OrderHistory object
     */
    protected $lastOrderHistory;

    /**
     * construct method
     *
     * @param OrderInterface        $order            Order
     * @param OrderHistoryInterface $lastOrderHistory Last OrderHistory
     */
    public function __construct(OrderInterface $order, OrderHistoryInterface $lastOrderHistory)
    {
        $this->order = $order;
        $this->lastOrderHistory = $lastOrderHistory;
    }

    /**
     * Return order
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Return last OrderLineHistory object
     *
     * @return OrderHistoryInterface last OrderLineHistory object
     */
    public function getLastOrderHistory()
    {
        return $this->lastOrderHistory;
    }
}
